<?php
namespace App\Http\Controllers\Admin;

use App\WallpaperCategory;
use App\Classes\Image;
use App\DataWallpaper;
use App\DefaultSize;
use App\FilterByColor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Wallpaper\AddOrUpdateRequest;
use App\Http\Requests\Admin\Wallpaper\SearchRequest;
use App\Wallpaper;
use App\WallpaperInCategory;
use App\WallpaperFilterByColor;
use App\WallpaperSize;
use App\Traits\Controllers\Admin\WallpaperTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class WallpaperController extends Controller {
    private $image_intervention;

    public function __construct() {
        parent::__construct();

        $this->image_intervention = new Image();

        $this->model_cache = 'Wallpaper';
        $this->key_cache = 'wallpaper';
    }

    use WallpaperTrait;
    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $this->method_cache = 'GetItemsForAdmin';
        $this->tags_cache = ['wallpaper', 'page', $page];
        $wallpapers = $this->GetOrCreateItemFromCache();

        $i = 0;
        $count = count($wallpapers);
        $this->model_cache = 'WallpaperInCategory';
        $this->method_cache = 'GetCategoriesItem';
        $this->key_cache = 'wallpaper_categories';
        while ($i < $count) {
            $this->tags_cache = ['wallpaper_categories', 'item', $wallpapers[$i]->id];
            $this->parameters_cache = [$wallpapers[$i]->id];
            $wallpapers[$i]->categories = $this->GetOrCreateItemFromCache();
            $i++;
        }
        $data = (object)[
            'title' => 'Управление фотообоями',
            'route_name' => $this->route_name,
            'tree' => WallpaperCategory::GetTree(null, 'select_multiple'),
            'items' => $wallpapers
        ];
        return view('admin.items.wallpaper.main', ['page' => $data]);
    }

    public function PageAdd() {
        $this->model_cache = 'DefaultSize';
        $this->method_cache = 'GetItemsStatic';
        $this->key_cache = 'default_size';

        $size = $this->GetOrCreateItemFromCache();

        $this->model_cache = 'FilterByColor';
        $this->key_cache = 'filter_by_color';

        $filter_by_color = $this->GetOrCreateItemFromCache();

        $data = (object)[
            'title' => 'Добавление фотообои',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'tree' => WallpaperCategory::GetTree(null, 'select_multiple', false),
            'size' => $size,
            'color' => $filter_by_color
        ];
        return view('admin.items.wallpaper.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:wallpapers,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->parameters_cache = [$id];

        $this->tags_cache = ['wallpaper', 'item', $id];
        $this->method_cache = 'GetItem';
        $wallpaper = $this->GetOrCreateItemFromCache();

        $this->tags_cache = ['wallpaper_data', 'item', $id];
        $this->method_cache = 'GetDataLocalization';
        $this->key_cache = 'wallpaper_data';
        $data_wallpaper = $this->GetOrCreateItemFromCache();

        $this->method_cache = 'GetFilterColors';
        $this->tags_cache = ['active_colors_wallpaper', 'item', $id];
        $this->key_cache = 'active_colors_wallpaper';
        $active_colors = $this->PrepareActiveData($this->GetOrCreateItemFromCache(), 'color');

        $this->method_cache = 'GetSizes';
        $this->tags_cache = ['active_sizes_wallpaper', 'item', $id];
        $this->key_cache = 'active_sizes_wallpaper';
        $active_sizes = $this->PrepareActiveData($this->GetOrCreateItemFromCache(), 'size');

        $this->model_cache = 'DefaultSize';
        $this->method_cache = 'GetItemsStatic';
        $this->tags_cache = null;
        $this->key_cache = 'default_size';
        $this->parameters_cache = [];
        $default_size = $this->GetOrCreateItemFromCache();

        $this->model_cache = 'FilterByColor';
        $this->method_cache = 'GetItemsStatic';
        $this->key_cache = 'filter_by_color';
        $filter_by_color = $this->GetOrCreateItemFromCache();

        $categories = $this->PrepareActiveData(Wallpaper::GetCategories($id), 'category');

        $data = (object)[
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'item_id' => $id,
            'item' => $wallpaper,
            'data' => $this->PrepareDataLocal($data_wallpaper),
            'tree' => WallpaperCategory::GetTree($categories, 'select_multiple'),
            'size' => $default_size,
            'color' => $filter_by_color,
            'active_color' => $active_colors,
            'active_size' => $active_sizes,
        ];
        return view('admin.items.wallpaper.work_on', ['page' => $data]);
    }

    public function Add(AddOrUpdateRequest $request) {
        $date = Carbon::now()->toDateString();
        $path = public_path('assets/images/wallpapers/' . $date);
        File::makeDirectory($path, $mode = 0777, true, true);
        $exp = $request->file('image')->getClientOriginalExtension();
        $image = uniqid('img_').'.'.$exp;
        $request->file('image')->move(public_path('assets/images/wallpapers/'.$date.'/'), $image);

        $preview_image = $this->image_intervention->CreatePreview(
            'assets/images/wallpapers/'.$date.'/'.$image,
            'assets/images/wallpapers/'.$date.'/',
            $exp, 580, 435
        );

        $item_id = Wallpaper::CreateItem($request->vendor_code,
                                       $date.'/'.$image, $date.'/'.$preview_image,
                                       $request->min_width,
                                       $request->max_width,
                                       $request->min_height,
                                       $request->max_height,
                                       $request->status);

        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            $meta_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $meta_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $meta_keywords  = $request['meta_keywords_'.$this->active_local[$i]->lang];
            $tags = $request['tags_'.$this->active_local[$i]->lang];

            DataWallpaper::CreateItem($item_id, $this->active_local[$i]->id, $name,
                $meta_title, $meta_description, $meta_keywords, $tags);
            $i++;
        }

        WallpaperInCategory::CreateItems($item_id, $request->category);
        WallpaperSize::CreateItems($item_id, $request->size);
        if (isset($request->color)) {
            WallpaperFilterByColor::CreateItems($item_id, $request->color);
        }

        $this->tags_cache = ['wallpaper', 'page'];
        $this->ForgetItemsOfPaginate();

        return response()->json([
            'status' => 'success',
            'item_id' => $item_id,
            'preview_image' => $date.'/'.$preview_image
        ]);
    }

    public function Update(AddOrUpdateRequest $request) {
        $this->parameters_cache = [$request->item_id];

        if (in_array(1, $request->category)) {
            return response()->json([
                'error' => 'Уберите с списка категорий "Корневая категория"'
            ]);
        }
        $item = Wallpaper::GetItem($request->item_id);
        if ($request->vendor_code != $item->vendor_code) {
            $validator = Validator::make(
                ['vendor_code' => $request->vendor_code],
                ['vendor_code' => 'unique:wallpapers,vendor_code']
            );
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
        }

        if (isset($request->image)) {
            Wallpaper::DeleteModularImages($request->item_id);
            $this->image_intervention->DeleteImages('/assets/images/wallpapers/', [
                $item->image, $item->preview_image
            ]);

            $date = Carbon::now()->toDateString();
            $path = public_path('assets/images/wallpapers/' . $date);
            File::makeDirectory($path, $mode = 0777, true, true);
            $exp = $request->file('image')->getClientOriginalExtension();
            $image = uniqid('img_').'.'.$exp;
            $request->file('image')->move(public_path('assets/images/wallpapers/'.$date.'/'), $image);

            $preview_image = $this->image_intervention->CreatePreview(
                'assets/images/wallpapers/'.$date.'/'.$image,
                'assets/images/wallpapers/'.$date.'/',
                $exp, 580, 435
            );

            Wallpaper::UpdateItem($request->item_id, $request->vendor_code,
                $date.'/'.$image, $date.'/'.$preview_image, $request->min_width,
                $request->max_width, $request->min_height, $request->max_height, $request->status);

            $this->tags_cache = ['wallpaper', 'item', $request->item_id];
            $this->ForgetItemInCache();
        }
        else {
            Wallpaper::UpdateItem($request->item_id, $request->vendor_code,
                null, null, $request->min_width,
                $request->max_width, $request->min_height, $request->max_height, $request->status);

            $this->tags_cache = ['wallpaper', 'item', $request->item_id];
            $this->ForgetItemInCache();
        }
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            $meta_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $meta_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $meta_keywords  = $request['meta_keywords_'.$this->active_local[$i]->lang];
            $tags = $request['tags_'.$this->active_local[$i]->lang];

            DataWallpaper::UpdateItem($request->item_id, $this->active_local[$i]->id, $name,
                $meta_title, $meta_description, $meta_keywords, $tags);
            $i++;
        }

        $this->tags_cache = ['wallpaper', 'page'];
        $this->ForgetItemsOfPaginate();

        $this->tags_cache = ['wallpaper_data', 'item', $request->item_id];
        $this->key_cache = 'wallpaper_data';
        $this->ForgetItemInCache();

        $this->tags_cache = ['wallpaper_categories', 'item', $request->item_id];
        $this->key_cache = 'wallpaper_categories';
        $this->ForgetItemInCache();

        Wallpaper::DeleteCategories($request->item_id);
        Wallpaper::DeleteFilterColors($request->item_id);
        Wallpaper::DeleteSizes($request->item_id);

        WallpaperInCategory::CreateItems($request->item_id, $request->category);


        WallpaperSize::CreateItems($request->item_id, $request->size);
        $this->tags_cache = ['active_sizes_wallpaper', 'item', $request->item_id];
        $this->key_cache = 'active_sizes_wallpaper';
        $this->ForgetItemInCache();

        if (isset($request->color)) {
            WallpaperFilterByColor::CreateItems($request->item_id, $request->color);

            $this->tags_cache = ['active_colors_wallpaper', 'item', $request->item_id];
            $this->key_cache = 'active_colors_wallpaper';
            $this->ForgetItemInCache();
        }

        if (isset($preview_image)) {
            return response()->json([
                'status' => 'success',
                'new_image' => $date.'/'.$preview_image
            ]);
        }
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:wallpapers,id']
        );
        if ($validator->fails()) {
            return redirect()->route('admin/wallpapers')->withErrors($validator);
        }

        Wallpaper::DeleteData($id);
        Wallpaper::DeleteCategories($id);
        Wallpaper::DeleteFilterColors($id);
        Wallpaper::DeleteSizes($id);
        Wallpaper::DeleteComments($id);
        Wallpaper::DeleteReviews($id);
        Wallpaper::DeleteItem($id);

        $this->tags_cache = ['wallpaper', 'page'];
        $this->ForgetItemsOfPaginate();

        $this->tags_cache = ['wallpaper', 'item', $id];
        $this->ForgetItemInCache();
        $this->tags_cache = ['wallpaper_data', 'item', $id];
        $this->key_cache = 'wallpaper_data';
        $this->ForgetItemInCache();
        $this->tags_cache = ['active_colors_wallpaper', 'item', $id];
        $this->key_cache = 'active_colors_wallpaper';
        $this->ForgetItemInCache();
        $this->tags_cache = ['active_sizes_wallpaper', 'item', $id];
        $this->key_cache = 'active_sizes_wallpaper';
        $this->ForgetItemInCache();
        $this->tags_cache = ['wallpaper_comment', 'page'];
        $this->ForgetItemsOfPaginate();
        $this->tags_cache = ['wallpaper_review', 'page'];
        $this->ForgetItemsOfPaginate();
        $this->tags_cache = ['recommend_wallpaper', 'page'];
        $this->ForgetItemsOfPaginate();



        return redirect()->route('admin/wallpapers')->with('success', 'Товар успешно удален');
    }

    public function Search(SearchRequest $request) {
        if ($request->has('category')) {
            if(($key = array_search(1, $request->category)) !== false) {
                $collect = new Collection($request->category);
                $categories = $collect->toArray();
                unset($categories[$key]);
                $request->merge(['category' => $categories]);
            }
        }

        $wallpapers = WallpaperSize::Search($request);
        $i = 0;
        $count = count($wallpapers);
        while ($i < $count) {
            $wallpapers[$i]->categories = WallpaperInCategory::GetCategoriesItem($wallpapers[$i]->id);
            $i++;
        }
        $tree = WallpaperCategory::GetTree(null, 'select_multiple');
        if ($request->has('category')) {
            $tree = WallpaperCategory::GetTree($request->category, 'select_multiple');
        }
        $data = (object)[
            'title' => 'Поиск фотообоив',
            'route_name' => $this->route_name,
            'tree' => $tree,
            'items' => $wallpapers,
        ];
        if ($request->has('vendor_code')) {
            $data->old_vendor_code = $request->vendor_code;
        }
        if ($request->has('status')) {
            $data->old_status = $request->status;
        }
        if ($request->has('name')) {
            $data->old_name = $request->name;
        }
        if ($request->has('date_start')) {
            $data->old_date_start = $request->date_start;
        }
        if ($request->has('date_end')) {
            $data->old_date_end = $request->date_end;
        }
        return view('admin.items.wallpaper.main', ['page' => $data]);
    }
}
