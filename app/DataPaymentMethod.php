<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPaymentMethod extends Model
{
    public $timestamps = false;

    public static function CreateItem($id, $lang_id, $name) {
        $item = new DataPaymentMethod();
        $item->payment_method_id = $id;
        $item->lang_id = $lang_id;
        $item->name = $name;
        $item->save();
    }

    public static function UpdateItem($id, $lang_id, $name) {
        $where = [
            ['payment_method_id', $id],
            ['lang_id', $lang_id]
        ];
        $data = ['name' => $name];
        if (DataPaymentMethod::where($where)->count() == 0) {
            DataPaymentMethod::insert(['payment_method_id' => $id, 'lang_id' => $lang_id]);
        }
        DataPaymentMethod::where($where)->update($data);
    }
}
