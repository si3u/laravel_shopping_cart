<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductComment
 *
 * @mixin \Eloquent
 */
class ProductComment extends Model
{
    protected $primaryKey = 'id';

    protected function GetItems($product_id) {
        return ProductComment::orderBy('created_at', 'desc')
            ->where([
                ['product_id' => $product_id],
                ['check_status' => true]
            ])
            ->paginate(15);
    }

    protected function UpdateStatus($id, $status) {
        $item = ProductComment::find($id);
        $item->check_status = $status;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function CreateItem($product_id, $name, $email, $message) {
        $item = new ProductComment();
        $item->product_id = $product_id;
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
}
