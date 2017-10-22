<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class WallpaperInCategory extends Model
{
    public $timestamps = false;

    public static function CreateItems($product_id, $categories) {
        $data = [];
        $i = 0;
        $count = count($categories);
        while ($i < $count) {
            $data[] = [
                'wallpaper_id' => $product_id,
                'category_id' => $categories[$i]
            ];
            $i++;
        }
        WallpaperInCategory::insert($data);
    }

    public static function GetCategoriesItem($id) {
        return DB::table('wallpaper_in_categories')
            ->where('wallpaper_in_categories.wallpaper_id', $id)
            ->join('data_wallpaper_categories', 'wallpaper_in_categories.category_id', '=', 'data_wallpaper_categories.category_id')
            ->where('data_wallpaper_categories.lang_id', 1)
            ->select(
                'data_wallpaper_categories.category_id as id',
                'data_wallpaper_categories.name'
            )
            ->get();
    }
}
