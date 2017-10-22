<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
