<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextSection extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'section';

    public static function GetItem($section, $lang_id) {
        return TextSection::where('section', $section)
                        ->where('lang_id', $lang_id)
                        ->select('value')
                        ->first();
    }

    protected function GetItems($section) {
        return TextSection::where('section', $section)->get();
    }

    protected function UpdateItem($section, $lang_id, $value) {
        TextSection::where(['section' => $section, 'lang_id' => $lang_id])->update(['value' => $value]);
    }
}
