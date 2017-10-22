<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    public static function CreateItems($data) {
        OrderItem::insert($data);
    }
}
