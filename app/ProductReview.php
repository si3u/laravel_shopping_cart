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

    public function scopeMainSelect($query) {
        return $query->select(
            'products.id as product_id',
            'product_reviews.id',
            'data_products.name as product_name',
            'products.preview_image as product_image',
            'product_reviews.check_status',
            'product_reviews.read_status',
            'product_reviews.rating',
            'product_reviews.name',
            'product_reviews.email',
            'product_reviews.message',
            'product_reviews.created_at'
        );
    }

    protected function GetData($id = null) {
        $query = ProductReview::query();
        $query->join('products', 'product_reviews.product_id', '=', 'products.id');
        $query->join('data_products', 'product_reviews.product_id', '=', 'data_products.product_id');
        $query->where('data_products.lang_id', 1);
        if ($id == null) {
            return $query->orderBy('created_at', 'desc')
                ->mainSelect()
                ->paginate(10);
        }
        else {
            return $query->where('product_reviews.id', $id)
                ->mainSelect()
                ->first();
        }
    }

    protected function UpdateItem($id, $status, $rating, $name, $email, $message) {
        $item = ProductReview::find($id);
        $item->check_status = $status;
        $item->rating = $rating;
        $item->name = $name;
        $item->email = $email;
        $item->message = $message;

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

    protected function Search($request) {
        $query = ProductReview::query();
        $query->join('products', 'product_reviews.product_id', '=', 'products.id');
        $query->join('data_products', 'product_reviews.product_id', '=', 'data_products.product_id');
        $query->where('data_products.lang_id', 1);
        if ($request->has('vendor_code')) {
            $query->where('products.vendor_code', $request->vendor_code);
        }
        if ($request->has('email')) {
            $query->where('product_reviews.email', $request->email);
        }
        if ($request->has('text_search')) {
            $query->where('product_reviews.message', 'LIKE', '%'.$request->text_search.'%');
        }
        if ($request->has('check_status')) {
            if ($request->check_status == '1') {
                $query->where('product_reviews.check_status', true);
            }
            if ($request->check_status == '2') {
                $query->where('product_reviews.check_status', false);
            }
        }
        if ($request->has('read_status')) {
            $query->where('product_reviews.read_status', false);
        }
        if ($request->has('score')) {
            $query->where('rating', $request->score);
        }
        if ($request->has('date_start') && $request->has('date_end')) {
            $query->whereBetween(
                'product_reviews.created_at',
                [$request->date_start, $request->date_end]
            );
        }
        if (!$request->has('date_start') && $request->has('date_end')) {
            $query->where('product_reviews.created_at', '<=', $request->date_end);
        }
        if ($request->has('date_start') && !$request->has('date_end')) {
            $query->where('product_reviews.created_at', '>=', $request->date_start);
        }
        $query->orderBy('product_reviews.created_at', 'desc');
        return $query->mainSelect()->paginate(10);
    }
}
