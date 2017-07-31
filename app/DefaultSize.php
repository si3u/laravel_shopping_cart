<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DefaultSize
 *
 * @property int $id
 * @property int $width
 * @property int $height
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DefaultSize whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DefaultSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DefaultSize whereWidth($value)
 * @mixin \Eloquent
 */
class DefaultSize extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function GetItems() {
        return DefaultSize::orderBy('width', 'asc')->paginate(10);
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
