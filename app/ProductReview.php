<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductReview
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property int $check_status
 * @property int $rating
 * @property string $name
 * @property string $email
 * @property string $message
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereCheckStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductReview whereUpdatedAt($value)
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
