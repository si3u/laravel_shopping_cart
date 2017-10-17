<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataContact extends Model
{
    public $timestamps = false;
    
    public static function UpdateItem($lang_id,
                                      $addresses,
                                      $working_days) {
        $where = [
            ['contact_id', '=', 1],
            ['lang_id', '=', $lang_id],
        ];
        $data = [
            'addresses' => $addresses,
            'working_days' => $working_days
        ];
        DataContact::where($where)->update($data);
    }
}
