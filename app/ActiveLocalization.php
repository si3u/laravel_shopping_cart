<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ActiveLocalization
 *
 * @property int $id
 * @property string $lang
 * @property string $name
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ActiveLocalization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ActiveLocalization whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ActiveLocalization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ActiveLocalization whereStatus($value)
 * @mixin \Eloquent
 */
class ActiveLocalization extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';

    public static function GetActive() {
        return ActiveLocalization::where('status', true)->get();
    }
    protected function GetAll() {
        return ActiveLocalization::get();
    }
    protected function UpdateItem($status) {
        $i = 0;
        $id = 1;
        while ($i < count($status)) {
            ActiveLocalization::where('id', $id)->update(['status' => $status[$i]]);
            $id++;
            $i++;
        }
        return true;
    }
}
