<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WallpaperSize extends Model
{
    public $timestamps = false;
    public static function CreateItems($wallpaper_id, $sizes) {
        $data = [];
        $i = 0;
        $count = count($sizes);
        while ($i < $count) {
            $data[] = [
                'wallpaper_id' => $wallpaper_id,
                'size_id' => $sizes[$i]
            ];
            $i++;
        }
        WallpaperSize::insert($data);
    }
}
