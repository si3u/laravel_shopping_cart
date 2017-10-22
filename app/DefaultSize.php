<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultSize extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function GetItems() {
        return DefaultSize::orderBy('width', 'asc')
        ->paginate(10);
    }

    public static function GetItemsStatic() {
        return DefaultSize::orderBy('width', 'asc')->get();
    }

    protected function CountItem($width, $height) {
        return DefaultSize::where([['width', '=', $width],['height', '=', $height]])->count();
    }

    protected function CreateItem($width, $height) {
        return DefaultSize::insertGetId(['width' => $width, 'height' => $height]);
    }

    protected function DeleteItem($id) {
        DefaultSize::find($id)->delete();
    }
}
