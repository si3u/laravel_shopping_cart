<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FilterByColor
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $hex
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FilterByColor whereHex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FilterByColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FilterByColor whereName($value)
 */
class FilterByColor extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function GetItems() {
        return FilterByColor::orderBy('id', 'desc')->paginate(10);
    }

    public static function GetItemsStatic() {
        return FilterByColor::orderBy('id', 'desc')->get();
    }

    protected function CreateItem($name, $hex) {
        return FilterByColor::insertGetId(['name' => $name, 'hex' => $hex]);
    }

    protected function DeleteItem($id) {
        FilterByColor::find($id)->delete();
        return true;
    }
}
