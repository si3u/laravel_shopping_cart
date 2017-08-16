<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrderItem
 *
 * @property int $order_id
 * @property int $width
 * @property int $height
 * @property int $canvas
 * @property int $type
 * @property int|null $modular_id
 * @property string|null $crop_image
 * @property float $price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereCanvas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereCropImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereModularId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereWidth($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    public $timestamps = false;

    public static function CreateItems($data) {
        OrderItem::insert($data);
    }
}
