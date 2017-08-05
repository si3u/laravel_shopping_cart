<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductFilterByColor
 *
 * @property int $product_id
 * @property int $color_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductFilterByColor whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductFilterByColor whereProductId($value)
 * @mixin \Eloquent
 */
class ProductFilterByColor extends Model
{
    public $timestamps = false;
}
