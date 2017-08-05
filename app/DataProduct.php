<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DataProduct
 *
 * @property int $product_id
 * @property int $lang_id
 * @property string $name
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereLangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataProduct whereTags($value)
 * @mixin \Eloquent
 */
class DataProduct extends Model {
    public $timestamps = false;
}
