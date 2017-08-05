<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property int $id
 * @property int $vendor_code
 * @property string $image
 * @property string $preview_image
 * @property int $min_width
 * @property int $max_width
 * @property int $min_height
 * @property int $max_height
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMaxHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMaxWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMinHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMinWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereVendorCode($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $primaryKey = 'id';

    protected function Comments() {
        return $this->hasMany('App\ProductComment', 'product_id');
    }

    protected function Categories() {
        return $this->hasMany('App\ProductCategory', 'product_id');
    }

    protected function FilterColors() {
        return $this->hasMany('App\ProductFilterByColor', 'product_id');
    }

    protected function Sizes() {
        return $this->hasMany('App\ProductSize', 'product_id');
    }

    protected function ModularImages() {
        return $this->hasMany('App\ProductModularImage', 'product_id');
    }

    protected function DataLocalization() {
        return $this->hasMany('App\ProductModularImage', 'product_id');
    }


    protected function CreateItem($vendor_code,
                                  $image,
                                  $preview_image,
                                  $min_width,
                                  $max_width,
                                  $min_height,
                                  $max_height) {
        $data = [
            'vendor_code' => $vendor_code,
            'image' => $image,
            'preview_image' => $preview_image,
            'min_width' => $min_width,
            'max_width' =>$max_width,
            'min_height' => $min_height,
            'max_height' => $max_height
        ];
        return Product::insertGetId($data);
    }


}
