<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TextPage
 *
 * @property int $id
 * @property int $lang_id
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextPage whereLangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TextPage whereValue($value)
 * @mixin \Eloquent
 */
class TextPage extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function GetItems($id) {
        return TextPage::where('id', $id)->get();
    }

    protected function UpdateItem($id, $lang_id, $value) {
        TextPage::where(['id' => $id, 'lang_id' => $lang_id])->update(['value' => $value]);
    }
}
