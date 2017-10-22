<?php
namespace App\Traits\Models;
trait WallpaperTrait {
    /**
     * @return mixed
     */
    protected function Reviews() {
        return $this->hasMany('App\WallpaperReview', 'wallpaper_id');
    }

    /**
     * @return mixed
     */
    protected function Comments() {
        return $this->hasMany('App\WallpaperComment', 'wallpaper_id');
    }

    /**
     * @return mixed
     */
    protected function Categories() {
        return $this->hasMany('App\WallpaperInCategory', 'wallpaper_id');
    }

    /**
     * @return mixed
     */
    protected function FilterColors() {
        return $this->hasMany('App\WallpaperFilterByColor', 'wallpaper_id');
    }

    /**
     * @return mixed
     */
    protected function Sizes() {
        return $this->hasMany('App\WallpaperSize', 'wallpaper_id');
    }

    /**
     * @return mixed
     */
    protected function DataLocalization() {
        return $this->hasMany('App\DataWallpaper', 'wallpaper_id');
    }
}
