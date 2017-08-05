<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductComment
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property int $check_status
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

    protected function UpdateStatus($id, $status) {
        $item = ProductComment::find($id);
        $item->check_status = $status;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function UpdateItem($id, $product_id, $name, $email, $message) {
        $item = ProductComment::find($id);
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
