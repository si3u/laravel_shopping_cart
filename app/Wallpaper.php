<?php

namespace App;

use App\Classes\Image;
use App\Traits\Models\WallpaperTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallpaper extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'id';
    private $image_intervention;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->image_intervention = new Image();
    }

    use WallpaperTrait;

    protected function GetItemsForAdmin() {
        return DB::table('wallpapers')
            ->join('data_wallpapers', 'wallpapers.id', '=', 'data_wallpapers.wallpaper_id')
            ->where('data_wallpapers.lang_id', 1)
            ->orderBy('created_at', 'desc')
            ->select(
                'wallpapers.id',
                'wallpapers.vendor_code',
                'wallpapers.status',
                'wallpapers.preview_image as image',
                'wallpapers.created_at',
                'data_wallpapers.name'
            )->paginate(10);
    }

    public static function GetItem($id) {
        return Wallpaper::find($id);
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
        return Wallpaper::insertGetId($data);
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
        $item = Wallpaper::find($id);
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
        return Wallpaper::find($id)->DataLocalization()->get();
    }
    protected function GetCategories($id) {
        return Wallpaper::find($id)->Categories()->select('category_id')->get();
    }
    protected function GetFilterColors($id) {
        return Wallpaper::find($id)->FilterColors()->select('color_id')->get();
    }
    protected function GetSizes($id) {
        return Wallpaper::find($id)->Sizes()->select('size_id')->get();
    }

    protected function DeleteItem($id) {
        $item = Wallpaper::find($id);
        $this->image_intervention->DeleteImages('/assets/images/wallpapers/', [
            $item->image, $item->preview_image
        ]);
        $item->delete();
    }
    protected function DeleteCategories($id) {
        Wallpaper::find($id)->Categories()->delete();
    }
    protected function DeleteFilterColors($id) {
        Wallpaper::find($id)->FilterColors()->delete();
    }
    protected function DeleteSizes($id) {
        Wallpaper::find($id)->Sizes()->delete();
    }
    protected function DeleteComments($id) {
        Wallpaper::find($id)->Comments()->delete();
    }
    protected function DeleteReviews($id) {
        Wallpaper::find($id)->Reviews()->delete();
    }
    protected function DeleteData($id) {
        Wallpaper::find($id)->DataLocalization()->delete();
    }

    protected function Search($options) {
        $query = Wallpaper::query();
        if (isset($options->status)) {
            $query->where('wallpapers.status', $options->status);
        }
        $query->join('data_wallpapers', 'wallpapers.id', '=', 'data_wallpapers.wallpaper_id');
        $query->join('wallpaper_in_categories', 'wallpaper.id', '=', 'Wallpaper_in_categories.wallpaper_id');

        if (isset($options->vendor_code)) {
            $query->where('wallpaper.vendor_code', $options->vendor_code);
        }

        if (isset($options->name)) {
            $query->where('data_wallpapers.name', 'LIKE', '%'.$options->name.'%');
        }

        if (isset($options->category)) {
            $query->whereIn('wallpaper_in_categories.category_id', $options->category);
        }
        if (isset($options->date_start) && isset($options->date_end)) {
            $query->where([
                ['created_at', '>=', $options->date_start],
                ['created_at', '<=', $options->date_end]
            ]);
        }
        if (isset($options->date_start) && !isset($options->date_end)) {
            $query->where('created_at', '>=', $options->date_start);
        }
        if (!isset($options->date_start) && isset($options->date_end)) {
            $query->where('created_at', '<=', $options->date_end);
        }
        $query->select(
            'wallpapers.id',
            'wallpapers.vendor_code',
            'wallpapers.preview_image as image',
            'wallpapers.status',
            'wallpapers.created_at',
            'data_wallpapers.name'
        )->orderBy('created_at', 'desc')->groupBy('id');
        return $query->paginate(10);
    }
}
