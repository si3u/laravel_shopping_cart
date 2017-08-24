<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SizeModularImage
 *
 * @property int $id
 * @property int $modular_image_id
 * @property int $number
 * @property int $width
 * @property int $height
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SizeModularImage whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SizeModularImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SizeModularImage whereModularImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SizeModularImage whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SizeModularImage whereWidth($value)
 * @mixin \Eloquent
 */
class SizeModularImage extends Model
{
    public $timestamps = false;

    protected function CountNumber($modular_image_id, $number) {
        return SizeModularImage::where([
                ['modular_image_id', $modular_image_id],
                ['number', $number]
            ])->count();
    }
    protected function CreateItem($modular_image_id, $number, $w, $h) {
        return SizeModularImage::insertGetId([
            'modular_image_id' => $modular_image_id,
            'number' => $number,
            'width' => $w,
            'height' => $h
        ]);
    }
    protected function DeleteItem($id) {
        SizeModularImage::where('id', $id)->delete();
    }
}
