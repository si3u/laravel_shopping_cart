<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WallpaperFilterByColor extends Model
{
    public $timestamps = false;
    public static function CreateItems($wallpaper_id, $colors) {
        $data = [];
        $i = 0;
        $count = count($colors);
        while ($i < $count) {
            $data[] = [
                'wallpaper_id' => $wallpaper_id,
                'color_id' => $colors[$i]
            ];
            $i++;
        }
        WallpaperFilterByColor::insert($data);
    }
}
