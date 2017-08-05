<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductCategory
 *
 * @property int $product_id
 * @property int $category_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductCategory whereProductId($value)
 * @mixin \Eloquent
 */
class ProductCategory extends Model
{
    public $timestamps = false;

    public static function CreateItem($product_id, $category_id) {
        ProductCategory::insert([
            'product_id' => $product_id,
            'category_id' => $category_id
        ]);
    }
}
