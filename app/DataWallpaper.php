<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataWallpaper extends Model
{
    protected $primaryKey = 'wallpaper_id';
    public $timestamps = false;

    public static function CreateItem($wallpaper_id,
                                      $lang_id,
                                      $name,
                                      $meta_title = null,
                                      $meta_description = null,
                                      $meta_keywords = null,
                                      $tags = null) {
        $item  = new DataWallpaper();
        $item->wallpaper_id = $wallpaper_id;
        $item->lang_id = $lang_id;
        $item->name = $name;
        $item->meta_title = $meta_title;
        $item->meta_description = $meta_description;
        $item->meta_keywords = $meta_keywords;
        $item->tags = $tags;

        $item->save();
    }

    public static function UpdateItem($wallpaper_id,
                                      $lang_id,
                                      $name,
                                      $meta_title = null,
                                      $meta_description = null,
                                      $meta_keywords = null,
                                      $tags = null) {
        $where = [
            ['wallpaper_id', '=', $wallpaper_id],
            ['lang_id', '=', $lang_id],
        ];
        if (DataWallpaper::where($where)->count() == 0) {
            DataWallpaper::insert(['wallpaper_id' => $wallpaper_id, 'lang_id' => $lang_id]);
        }
        $data = [
            'name' => $name,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'tags' => $tags
        ];
        DataWallpaper::where($where)->update($data);
    }
}
