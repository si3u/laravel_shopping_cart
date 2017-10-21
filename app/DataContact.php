<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DataContact
 *
 * @property int $contact_id
 * @property int $lang_id
 * @property string|null $addresses
 * @property string|null $working_days
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataContact whereAddresses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataContact whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataContact whereLangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataContact whereWorkingDays($value)
 * @mixin \Eloquent
 */
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
