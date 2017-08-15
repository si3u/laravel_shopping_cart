<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
