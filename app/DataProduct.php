<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DataProduct
 *
 * @property int $product_id
 * @property int $lang_id
 * @property string $name
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereLangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereTags($value)
 * @mixin \Eloquent
 */
class DataProduct extends Model {
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    public static function CreateItem($product_id,
                                      $lang_id,
                                      $name,
                                      $meta_title = null,
                                      $meta_description = null,
                                      $meta_keywords = null,
                                      $tags = null) {
        $item  = new DataProduct();
        $item->product_id = $product_id;
        $item->lang_id = $lang_id;
        $item->name = $name;
        $item->meta_title = $meta_title;
        $item->meta_description = $meta_description;
        $item->meta_keywords = $meta_keywords;
        $item->tags = $tags;

        $item->save();
    }

    public static function UpdateItem($product_id,
                                      $lang_id,
                                      $name,
                                      $meta_title = null,
                                      $meta_description = null,
                                      $meta_keywords = null,
                                      $tags = null) {
        $where = [
            ['product_id', '=', $product_id],
            ['lang_id', '=', $lang_id],
        ];
        if (DataProduct::where($where)->count() == 0) {
            DataProduct::insert(['product_id' => $product_id, 'lang_id' => $lang_id]);
        }
        $data = [
            'name' => $name,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'tags' => $tags
        ];
        DataProduct::where($where)->update($data);
    }
}
