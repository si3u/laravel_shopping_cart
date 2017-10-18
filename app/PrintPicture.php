<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PrintPicture extends Model
{
    private $datatime;
    public $timestamps = true;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->datetime = Carbon::now()->toDateTimeString();
    }

    protected function GetItems() {
        return PrintPicture::orderBy('id', 'desc')->paginate(10);
    }

    protected function CreateItem($tel, $width, $height, $canvas, $file, $exp, $local) {
        PrintPicture::insert([
            'tel' => $tel,
            'width' => $width,
            'height' => $height,
            'canvas' => $canvas,
            'file' => $file,
            'file_exp' => $exp,
            'local' => $local,
            'created_at' => $this->datetime,
            'updated_at' => $this->datetime,
        ]);
    }
}
