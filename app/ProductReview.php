<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductReview
 *
 * @mixin \Eloquent
 */
class ProductReview extends Model
{
    protected $primaryKey = 'id';

    protected function GetItems($product_id) {
        return ProductReview::orderBy('created_at', 'desc')
            ->where([
                ['product_id' => $product_id],
                ['check_status' => true]
            ])
            ->paginate(15);
    }

    protected function UpdateStatus($id, $status) {
        $item = ProductReview::find($id);
        $item->check_status = $status;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function CreateItem($product_id, $rating, $name, $email, $message) {
        $item = new ProductReview();
        $item->product_id = $product_id;
        $item->rating = $rating;
        $item->name = $name;
        $item->email = $email;
        $item->message = $message;

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function DeleteItem($id) {
        ProductReview::find($id)->delete();
    }
}
