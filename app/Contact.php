<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Contact
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $tel
 * @property string|null $addresses
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereAddresses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereTel($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected function GetData() {
        return Contact::find(1);
    }

    protected function UpdateItem($email, $tel, $address) {
        $item = Contact::find(1);
        $item->email = $email;
        $item->tel = $tel;
        $item->addresses = $address;
        $item->save();
    }
}
