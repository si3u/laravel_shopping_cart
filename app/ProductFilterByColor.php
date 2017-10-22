<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFilterByColor extends Model
{
    public $timestamps = false;
    public static function CreateItems($product_id, $colors) {
        $data = [];
        $i = 0;
        $count = count($colors);
        while ($i < $count) {
            $data[] = [
                'product_id' => $product_id,
                'color_id' => $colors[$i]
            ];
            $i++;
        }
        ProductFilterByColor::insert($data);
    }
}
