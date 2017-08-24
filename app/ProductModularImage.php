<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductModularImage
 *
 * @property int $product_id
 * @property int $modular_image_id
 * @property string $image
 * @property string $preview_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModularImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModularImage whereModularImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModularImage wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModularImage whereProductId($value)
 * @mixin \Eloquent
 */
class ProductModularImage extends Model {
    public $timestamps = false;

    public static function CreateItemStatic($data) {
        ProductModularImage::insert($data);
    }
}
