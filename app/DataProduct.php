<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
