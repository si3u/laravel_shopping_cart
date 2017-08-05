<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Price
 *
 * @property float|null $natural_canvas
 * @property float|null $artificial_canvas
 * @property float|null $running_meter
 * @property float|null $for_work
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereArtificialCanvas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereForWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereNaturalCanvas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereRunningMeter($value)
 * @mixin \Eloquent
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereId($value)
 */
class Price extends Model
{
   protected $primaryKey = 'id';
   public $timestamps = false;

    protected function GetData() {
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
