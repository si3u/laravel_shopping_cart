<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
