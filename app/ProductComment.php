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
 */
class ProductComment extends Model
{
    protected $primaryKey = 'id';

    protected function GetData($id = null) {
        $query = ProductComment::query();
        $query->join('products', 'product_comments.product_id', '=', 'products.id');
        if ($id != null) {
            $query->where('product_comments.id', $id);
            $query->select(
                'products.id as product_id',
                'products.vendor_code',
                'products.preview_image as product_image',
                'product_comments.id',
                'data_products.name as product_name',
                'product_comments.check_status',
                'product_comments.name',
                'product_comments.email',
                'product_comments.message',
                'product_comments.created_at'
            );
        }
        else {
            $query->select(
                'products.id as product_id',
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
        $query->join('data_products', 'product_comments.product_id', '=', 'data_products.product_id');
        $query->where('data_products.lang_id', 1);
        if ($id == null) {
            $query->orderBy('product_comments.created_at', 'desc');
            return $query->paginate(10);
        }
        return $query->first();
    }

    protected function UpdateReadStatus($id) {
        $item = ProductComment::find($id);
        $item->read_status = true;
        $item->save();
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
}
