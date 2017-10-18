<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Print extends Model
{
    private $datatime;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->datetime = Carbon::now()->toDateTimeString();
    }

    protected function GetItems() {
        return Print::orderBy('id', 'desc')->paginate(10);
    }

    protected function CreateItem($tel, $width, $height, $file, $local) {
        Print::insert([
            'tel' => $tel,
            'width' => $width,
            'height' => $height,
            'file' => $file,
            'local' => $local,
            'created_at' => $this->datatime,
            'updated_at' => $this->datatime,
        ]);
    }
}
