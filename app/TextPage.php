<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextPage extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function GetItem($id, $lang_id) {
        return TextPage::where([
            'id' => $id,
            'lang_id' => $lang_id
        ])->select('value')->first();
    }

    protected function GetItems($id) {
        return TextPage::where('id', $id)->get();
    }

    protected function UpdateItem($id, $lang_id, $value) {
        TextPage::where(['id' => $id, 'lang_id' => $lang_id])->update(['value' => $value]);
    }
}
