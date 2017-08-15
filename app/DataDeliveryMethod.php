<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataDeliveryMethod extends Model
{
    public $timestamps = false;

    public static function CreateItem($id, $lang, $name) {
        $item = new DataDeliveryMethod();
        $item->delivery_method_id = $id;
        $item->lang_id = $lang;
        $item->name = $name;
        $item->save();
    }

    public static function UpdateItem($id, $lang_id, $name) {
        $where = [
            ['delivery_method_id', $id],
            ['lang_id', $lang_id]
        ];
        $data = ['name' => $name];

        DataDeliveryMethod::where($where)->update($data);
    }
}
