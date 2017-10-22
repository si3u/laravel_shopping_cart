<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $primaryKey = 'id';
    public function scopeMainSelect($query) {
        return $query->select(
            'products.id as product_id',
            'products.vendor_code',
            'products.preview_image as product_image',
            'product_comments.id',
            'data_products.name as product_name',
            'product_comments.check_status',
            'product_comments.read_status',
            'product_comments.name',
            'product_comments.email',
            'product_comments.message',
            'product_comments.created_at'
        );
    }


    protected function GetData($product_id = null) {
        $query = ProductComment::query();
        $query->join('products', 'product_comments.product_id', '=', 'products.id');
        $query->join('data_products', 'product_comments.product_id', '=', 'data_products.product_id');
        $query->where('data_products.lang_id', 1);
        if ($product_id != null) {
            $query->where('product_comments.id', $product_id);
        }
        if ($product_id == null) {
            $query->orderBy('product_comments.id', 'desc');
            return $query->mainSelect()->paginate(10);
        }
        else {
            return $query->mainSelect()->first();
        }
    }

    protected function UpdateItem($id, $status, $name, $email, $message) {
        $item = ProductComment::find($id);
        $item->check_status = $status;
        $item->name = $name;
        $item->email = $email;
        $item->message = $message;

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function DeleteItem($id) {
        ProductComment::find($id)->delete();
    }

    protected function Search($request) {
        $query = ProductComment::query();
        $query->join('products', 'product_comments.product_id', '=', 'products.id');
        $query->join('data_products', 'product_comments.product_id', '=', 'data_products.product_id');

        if (isset($request->email)) {
            $query->where('product_comments.email', $request->email);
        }
        if (isset($request->text_search)) {
            $query->where('product_comments.message', 'LIKE', '%'.$request->text_search.'%');
        }
        if (isset($request->check_status)) {
            if ($request->check_status == '1') {
                $query->where('product_comments.check_status', true);
            }
            if ($request->check_status == '2') {
                $query->where('product_comments.check_status', false);
            }
        }
        if (isset($request->read_status)) {
            $query->where('product_comments.read_status', false);
        }
        if (isset($request->vendor_code)) {
            $query->where('products.vendor_code', $request->vendor_code);
        }
        if (isset($request->date_start) && isset($request->date_end)) {
            $query->whereBetween(
                'product_comments.created_at',
                [$request->date_start, $request->date_end]
            );
        }
        if (!isset($request->date_start) && isset($request->date_end)) {
            $query->where('product_comments.created_at', '<=', $request->date_end);
        }
        if (isset($request->date_start) && !isset($request->date_end)) {
            $query->where('product_comments.created_at', '>=', $request->date_start);
        }
        return $query->where('data_products.lang_id', 1)
            ->orderBy('product_comments.created_at', 'desc')
            ->mainSelect()
            ->paginate(10);
    }
}
