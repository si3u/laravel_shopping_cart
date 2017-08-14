<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingOrderStatus extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected function GetItems() {
        return SettingOrderStatus::paginate(10);
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
