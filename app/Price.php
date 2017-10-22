<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
   protected $primaryKey = 'id';
   public $timestamps = false;

    public static function GetData() {
        return Price::find(1);
    }

    protected function UpdateItem($natural_canvas,
                                  $artificial_canvas,
                                  $running_meter,
                                  $for_work) {
        $item = Price::find(1);
        $item->natural_canvas = $natural_canvas;
        $item->artificial_canvas = $artificial_canvas;
        $item->running_meter = $running_meter;
        $item->for_work = $for_work;
        if ($item->save()) {
            return true;
        }
        return false;
    }
}
