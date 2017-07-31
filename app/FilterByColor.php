<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FilterByColor
 *
 * @mixin \Eloquent
 */
class FilterByColor extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function GetItems() {
        return FilterByColor::paginate(10);
    }

    protected function CreateItem($name, $hex) {
        return FilterByColor::insertGetId(['name' => $name, 'hex' => $hex]);
    }

    protected function DeleteItem($id) {
        FilterByColor::find($id)->delete();
        return true;
    }
}
