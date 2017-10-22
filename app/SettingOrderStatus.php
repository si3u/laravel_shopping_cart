<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingOrderStatus extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';

    public static function GetActive() {
        $select = SettingOrderStatus::where('upon_receipt', true)->select('id')->first();
        if (isset($select->id)) {
            return $select->id;
        }
        return null;
    }

    public static function GetItemsStatic() {
        return SettingOrderStatus::orderBy('upon_receipt', 'desc')->get();
    }

    protected function GetItems() {
        return SettingOrderStatus::orderBy('id', 'desc')->paginate(10);
    }

    protected function CreateItem($name) {
        return SettingOrderStatus::insertGetId(['name' => $name]);
    }

    protected function DeleteItem($id) {
        SettingOrderStatus::find($id)->delete();
    }

    protected function GetItem($id) {
        return SettingOrderStatus::find($id);
    }

    protected function ChangeUponReceipt($id) {
        $old = SettingOrderStatus::where('upon_receipt', true)->first();
        if ($old != null) {
            $old->upon_receipt = false;
            $old->save();
        }
        $new = SettingOrderStatus::find($id);
        $new->upon_receipt = true;
        $new->save();
    }
}
