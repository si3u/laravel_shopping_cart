<?php

namespace App;

use App\Classes\Image;
use App\Traits\Models\ProductTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereStatus($value)
 */
class Product extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    private $image_intervention;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->image_intervention = new Image();
    }

    use ProductTrait;

    protected function GetItemsForAdmin() {
        return DB::table('products')
            ->join('data_products', 'products.id', '=', 'data_products.product_id')
            ->where('data_products.lang_id', 1)
            ->orderBy('created_at', 'desc')
            ->select(
                'products.id',
                'products.vendor_code',
                'products.status',
                'products.preview_image as image',
                'products.created_at',
                'data_products.name'
            )->paginate(10);
    }

    public static function GetItem($id) {
        return Product::find($id);
    }

    protected function CreateItem($vendor_code,
                                  $image,
                                  $preview_image,
                                  $min_width,
                                  $max_width,
                                  $min_height,
                                  $max_height,
                                  $status) {
        $datetime = Carbon::now()->toDateTimeString();
        $data = [
            'vendor_code' => $vendor_code,
            'image' => $image,
            'preview_image' => $preview_image,
            'min_width' => $min_width,
            'max_width' =>$max_width,
            'min_height' => $min_height,
            'max_height' => $max_height,
            'status' => $status,
            'created_at' => $datetime,
            'updated_at' => $datetime
        ];
        return Product::insertGetId($data);
    }

    protected function UpdateItem($id,
                                  $vendor_code,
                                  $image = null,
                                  $preview_image = null,
                                  $min_width,
                                  $max_width,
                                  $min_height,
                                  $max_height,
                                  $status) {
        $item = Product::find($id);
        $item->vendor_code = $vendor_code;
        if ($image != null) {
            $item->image = $image;
            $item->preview_image = $preview_image;
        }
        $item->min_width = $min_width;
        $item->max_width = $max_width;
        $item->min_height = $min_height;
        $item->max_height = $max_height;
        $item->status = $status;

        $item->save();
    }

    protected function GetDataLocalization($id) {
        return Product::find($id)->DataLocalization()->get();
    }
    protected function GetCategories($id) {
        return Product::find($id)->Categories()->select('category_id')->get();
    }
    protected function GetFilterColors($id) {
        return Product::find($id)->FilterColors()->select('color_id')->get();
    }
    protected function GetSizes($id) {
        return Product::find($id)->Sizes()->select('size_id')->get();
    }

    protected function DeleteItem($id) {
        $item = Product::find($id);
        $this->image_intervention->DeleteImages('/assets/images/products/', [
            $item->image, $item->preview_image
        ]);
        $item->delete();
    }
    protected function DeleteCategories($id) {
        Product::find($id)->Categories()->delete();
    }
    protected function DeleteFilterColors($id) {
        Product::find($id)->FilterColors()->delete();
    }
    protected function DeleteSizes($id) {
        Product::find($id)->Sizes()->delete();
    }
    protected function DeleteModularImages($id) {
        $data = Product::find($id)->ModularImages()->get();
        $prepare_array  = [];
        foreach ($data as $datum) {
            $prepare_array[] = $datum->image;
            $prepare_array[] = $datum->preview_image;
        }
        $this->image_intervention->DeleteImages('/assets/images/product_modular/', $prepare_array);
        Product::find($id)->ModularImages()->delete();
    }
    protected function DeleteComments($id) {
        Product::find($id)->Comments()->delete();
    }
    protected function DeleteReviews($id) {
        Product::find($id)->Reviews()->delete();
    }
    protected function DeleteData($id) {
        Product::find($id)->DataLocalization()->delete();
    }

    protected function Search($options) {
        $query = Product::query();
        if ($options->has('status')) {
            $query->where('products.status', $options->status);
        }
        $query->join('data_products', 'products.id', '=', 'data_products.product_id');
        $query->join('product_categories', 'products.id', '=', 'product_categories.product_id');

        if ($options->has('vendor_code')) {
            $query->where('products.vendor_code', $options->vendor_code);
        }

        if ($options->has('name')) {
            $query->where('data_products.name', 'LIKE', '%'.$options->name.'%');
        }

        if ($options->has('category')) {
            $query->whereIn('product_categories.category_id', $options->category);
        }
        if ($options->has('date_start') && $options->has('date_end')) {
            $query->where([
                ['created_at', '>=', $options->date_start],
                ['created_at', '<=', $options->date_end]
            ]);
        }
        if ($options->has('date_start') && !$options->has('date_end')) {
            $query->where('created_at', '>=', $options->date_start);
        }
        if (!$options->has('date_start') && $options->has('date_end')) {
            $query->where('created_at', '<=', $options->date_end);
        }
        $query->select(
            'products.id',
            'products.vendor_code',
            'products.preview_image as image',
            'products.status',
            'products.created_at',
            'data_products.name'
        )->orderBy('created_at', 'desc')->groupBy('id');
        return $query->paginate(10);
    }
}
