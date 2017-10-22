<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WallpaperReview extends Model
{
    protected $primaryKey = 'id';

    public function scopeMainSelect($query) {
        return $query->select(
            'wallpapers.id as wallpaper_id',
            'wallpaper_reviews.id',
            'data_wallpapers.name as wallpaper_name',
            'wallpapers.preview_image as wallpaper_image',
            'wallpaper_reviews.check_status',
            'wallpaper_reviews.read_status',
            'wallpaper_reviews.rating',
            'wallpaper_reviews.name',
            'wallpaper_reviews.email',
            'wallpaper_reviews.message',
            'wallpaper_reviews.created_at'
        );
    }

    protected function GetData($id = null) {
        $query = WallpaperReview::query();
        $query->join('wallpapers', 'wallpaper_reviews.wallpaper_id', '=', 'wallpapers.id');
        $query->join('data_wallpapers', 'wallpaper_reviews.wallpaper_id', '=', 'data_wallpapers.wallpaper_id');
        $query->where('data_wallpapers.lang_id', 1);
        if ($id === null) {
            return $query->orderBy('created_at', 'desc')
                ->mainSelect()
                ->paginate(10);
        }
        else {
            return $query->where('wallpaper_reviews.id', $id)
                ->mainSelect()
                ->first();
        }
    }

    protected function UpdateItem($id, $status, $rating, $name, $email, $message) {
        $item = WallpaperReview::find($id);
        $item->check_status = $status;
        $item->rating = $rating;
        $item->name = $name;
        $item->email = $email;
        $item->message = $message;

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function CreateItem($wallpaper_id, $rating, $name, $email, $message) {
        $item = new WallpaperReview();
        $item->wallpaper_id = $wallpaper_id;
        $item->rating = $rating;
        $item->name = $name;
        $item->email = $email;
        $item->message = $message;

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function DeleteItem($id) {
        WallpaperReview::find($id)->delete();
    }

    protected function Search($request) {
        $query = WallpaperReview::query();
        $query->join('wallpapers', 'wallpaper_reviews.wallpaper_id', '=', 'wallpapers.id');
        $query->join('data_wallpapers', 'wallpaper_reviews.wallpaper_id', '=', 'data_wallpapers.wallpaper_id');
        $query->where('data_wallpapers.lang_id', 1);
        if (isset($request->vendor_code)) {
            $query->where('wallpapers.vendor_code', $request->vendor_code);
        }
        if (isset($request->email)) {
            $query->where('wallpaper_reviews.email', $request->email);
        }
        if (isset($request->text_search)) {
            $query->where('wallpaper_reviews.message', 'LIKE', '%'.$request->text_search.'%');
        }
        if (isset($request->check_status)) {
            if ($request->check_status == '1') {
                $query->where('wallpaper_reviews.check_status', true);
            }
            if ($request->check_status == '2') {
                $query->where('wallpaper_reviews.check_status', false);
            }
        }
        if (isset($request->read_status)) {
            $query->where('wallpaper_reviews.read_status', false);
        }
        if (isset($request->score)) {
            if ($request->score != 0) {
                $query->where('rating', $request->score);
            }
        }
        if (isset($request->date_start) && isset($request->date_end)) {
            $query->whereBetween(
                'wallpaper_reviews.created_at',
                [$request->date_start, $request->date_end]
            );
        }
        if (!isset($request->date_start) && isset($request->date_end)) {
            $query->where('wallpaper_reviews.created_at', '<=', $request->date_end);
        }
        if (isset($request->date_start) && !isset($request->date_end)) {
            $query->where('wallpaper_reviews.created_at', '>=', $request->date_start);
        }
        $query->orderBy('wallpaper_reviews.created_at', 'desc');
        return $query->mainSelect()->paginate(10);
    }
}
