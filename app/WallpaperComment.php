<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WallpaperComment extends Model
{
    protected $primaryKey = 'id';
    public function scopeMainSelect($query) {
        return $query->select(
            'wallpapers.id as wallpaper_id',
            'wallpapers.vendor_code',
            'wallpapers.preview_image as wallpaper_image',
            'wallpaper_comments.id',
            'data_wallpapers.name as wallpaper_name',
            'wallpaper_comments.check_status',
            'wallpaper_comments.read_status',
            'wallpaper_comments.name',
            'wallpaper_comments.email',
            'wallpaper_comments.message',
            'wallpaper_comments.created_at'
        );
    }


    protected function GetData($wallpaper_id = null) {
        $query = WallpaperComment::query();
        $query->join('wallpapers', 'wallpaper_comments.product_id', '=', 'wallpapers.id');
        $query->join('data_wallpapers', 'wallpaper_comments.product_id', '=', 'data_wallpapers.product_id');
        $query->where('data_wallpapers.lang_id', 1);
        if ($wallpaper_id != null) {
            $query->where('wallpaper_comments.id', $wallpaper_id);
        }
        if ($wallpaper_id == null) {
            $query->orderBy('wallpaper_comments.id', 'desc');
            return $query->mainSelect()->paginate(10);
        }
        else {
            return $query->mainSelect()->first();
        }
    }

    protected function UpdateItem($id, $status, $name, $email, $message) {
        $item = WallpaperComment::find($id);
        $item->check_status = $status;
        $item->name = $name;
        $item->email = $email;
        $item->message = $message;

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function DeleteItem($id) {
        WallpaperComment::find($id)->delete();
    }

    protected function Search($request) {
        $query = WallpaperComment::query();
        $query->join('wallpapers', 'wallpaper_comments.product_id', '=', 'wallpapers.id');
        $query->join('data_wallpapers', 'wallpaper_comments.product_id', '=', 'data_wallpapers.product_id');

        if (isset($request->email)) {
            $query->where('wallpaper_comments.email', $request->email);
        }
        if (isset($request->text_search)) {
            $query->where('wallpaper_comments.message', 'LIKE', '%'.$request->text_search.'%');
        }
        if (isset($request->check_status)) {
            if ($request->check_status == '1') {
                $query->where('wallpaper_comments.check_status', true);
            }
            if ($request->check_status == '2') {
                $query->where('wallpaper_comments.check_status', false);
            }
        }
        if (isset($request->read_status)) {
            $query->where('wallpaper_comments.read_status', false);
        }
        if (isset($request->vendor_code)) {
            $query->where('wallpapers.vendor_code', $request->vendor_code);
        }
        if (isset($request->date_start) && isset($request->date_end)) {
            $query->whereBetween(
                'wallpaper_comments.created_at',
                [$request->date_start, $request->date_end]
            );
        }
        if (!isset($request->date_start) && isset($request->date_end)) {
            $query->where('wallpaper_comments.created_at', '<=', $request->date_end);
        }
        if (isset($request->date_start) && !isset($request->date_end)) {
            $query->where('wallpaper_comments.created_at', '>=', $request->date_start);
        }
        return $query->where('data_wallpapers.lang_id', 1)
            ->orderBy('wallpaper_comments.created_at', 'desc')
            ->mainSelect()
            ->paginate(10);
    }
}
