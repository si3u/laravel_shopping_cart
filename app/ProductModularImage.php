<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModularImage extends Model {
    public $timestamps = false;

    public static function CreateItemStatic($data) {
        ProductModularImage::insert($data);
    }
}
