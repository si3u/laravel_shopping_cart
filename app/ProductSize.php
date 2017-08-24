<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductSize
 *
 * @property int $product_id
 * @property int $size_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSize whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductSize whereSizeId($value)
 * @mixin \Eloquent
 */
class ProductSize extends Model
{
    public $timestamps = false;
    public static function CreateItems($product_id, $sizes) {
        $data = [];
        $i = 0;
        $count = count($sizes);
        while ($i < $count) {
            $data[] = [
                'product_id' => $product_id,
                'size_id' => $sizes[$i]
            ];
            $i++;
        }
        ProductSize::insert($data);
    }
}
