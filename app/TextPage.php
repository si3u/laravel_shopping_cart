<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextPage extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function GetItem($id) {
        return TextPage::find($id);
    }

    protected function UpdateItem($id, $value) {
        $item = TextPage::find($id);
        $item->value = $value;
        if ($item->save()) {
            return true;
        }
        return false;
    }
}
