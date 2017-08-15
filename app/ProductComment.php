<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\ProductComment
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property int $check_status
 * @property int $read_status
 * @property string $name
 * @property string $email
 * @property string $message
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereCheckStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment mainSelect()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductComment whereReadStatus($value)
 */
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


    protected function GetData($id = null) {
        $query = ProductComment::query();
        $query->join('products', 'product_comments.product_id', '=', 'products.id');
        $query->join('data_products', 'product_comments.product_id', '=', 'data_products.product_id');
        $query->where('data_products.lang_id', 1);
        if ($id != null) {
            $query->where('product_comments.id', $id);
        }
        if ($id == null) {
            $query->orderBy('product_comments.created_at', 'desc');
            return $query->mainSelect()->paginate(10);
        }
        return $query->mainSelect()->first();
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

        if ($request->has('email')) {
            $query->where('product_comments.email', $request->email);
        }
        if ($request->has('text_search')) {
            $query->where('product_comments.message', 'LIKE', '%'.$request->text_search.'%');
        }
        if ($request->has('check_status')) {
            if ($request->check_status == '1') {
                $query->where('product_comments.check_status', true);
            }
            if ($request->check_status == '2') {
                $query->where('product_comments.check_status', false);
            }
        }
        if ($request->has('read_status')) {
            $query->where('product_comments.read_status', false);
        }
        if ($request->has('vendor_code')) {
            $query->where('products.vendor_code', $request->vendor_code);
        }
        if ($request->has('date_start') && $request->has('date_end')) {
            $query->whereBetween(
                'product_comments.created_at',
                [$request->date_start, $request->date_end]
            );
        }
        if (!$request->has('date_start') && $request->has('date_end')) {
            $query->where('product_comments.created_at', '<=', $request->date_end);
        }
        if ($request->has('date_start') && !$request->has('date_end')) {
            $query->where('product_comments.created_at', '>=', $request->date_start);
        }
        return $query->where('data_products.lang_id', 1)
            ->orderBy('product_comments.created_at', 'desc')
            ->mainSelect()
            ->paginate(10);
    }
}
