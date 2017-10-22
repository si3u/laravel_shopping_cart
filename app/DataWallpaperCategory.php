<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataWallpaperCategory extends Model
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
        $item = new DataWallpaperCategory();
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
        if (DataWallpaperCategory::where($where)->count() == 0) {
            DataWallpaperCategory::insert(['category_id' => $category_id, 'lang_id' => $lang_id]);
        }
        $data = [
            'name' => $name,
            'description' => $description,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords
        ];
        DataWallpaperCategory::where($where)->update($data);
    }

    public static function DeleteItems($ids) {
        DataWallpaperCategory::whereIn('category_id', $ids)->delete();
    }
}
