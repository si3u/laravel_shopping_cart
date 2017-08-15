<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DataDeliveryMethod
 *
 * @property int $delivery_method_id
 * @property int $lang_id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataDeliveryMethod whereDeliveryMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataDeliveryMethod whereLangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataDeliveryMethod whereName($value)
 * @mixin \Eloquent
 */
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
