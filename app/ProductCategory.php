<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function CreateItems($product_id, $categories) {
        $data = [];
        $i = 0;
        $count = count($categories);
        while ($i < $count) {
            $data[] = [
                'product_id' => $product_id,
                'category_id' => $categories[$i]
            ];
            $i++;
        }
        ProductCategory::insert($data);
    }

    public static function GetCategoriesItem($id) {
        return DB::table('product_categories')
            ->where('product_categories.product_id', $id)
            ->join('data_categories', 'product_categories.category_id', '=', 'data_categories.category_id')
            ->where('data_categories.lang_id', 1)
            ->select(
                'data_categories.category_id as id',
                'data_categories.name'
            )
            ->get();
    }
}
