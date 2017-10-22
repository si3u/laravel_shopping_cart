<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataCategory extends Model
{
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    public static function CreateItem($category_id,
                                      $name,
                                      $lang_id,
                                      $description,
                                      $meta_title,
                                      $meta_description,
                                      $meta_keywords) {
        $item = new DataCategory();
        $item->category_id = $category_id;
        $item->name = $name;
        $item->lang_id = $lang_id;
        $item->description = $description;
        $item->meta_title = $meta_title;
        $item->meta_description = $meta_description;
        $item->meta_keywords = $meta_keywords;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    public static function UpdateItem($category_id,
                                      $name,
                                      $lang_id,
                                      $description,
                                      $meta_title,
                                      $meta_description,
                                      $meta_keywords) {
        $where = [
            ['category_id', '=', $category_id],
            ['lang_id', '=', $lang_id],
        ];
        if (DataCategory::where($where)->count() == 0) {
            DataCategory::insert(['category_id' => $category_id, 'lang_id' => $lang_id]);
        }
        $data = [
            'name' => $name,
            'description' => $description,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ];
        DataCategory::where($where)->update($data);
    }

    public static function DeleteItems($ids) {
        DataCategory::whereIn('category_id', $ids)->delete();
    }
}
