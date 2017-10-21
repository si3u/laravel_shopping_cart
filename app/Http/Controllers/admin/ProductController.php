<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Classes\Image;
use App\DataProduct;
use App\DefaultSize;
use App\FilterByColor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AddOrUpdateRequest;
use App\Http\Requests\Admin\Product\SearchRequest;
use App\Product;
use App\ProductCategory;
use App\ProductFilterByColor;
use App\ProductModularImage;
use App\ProductSize;
use App\Traits\Controllers\Admin\ProductTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class ProductController extends Controller {
    private $image_intervention;

    public function __construct() {
        parent::__construct();

        $this->image_intervention = new Image();

        $this->model_cache = 'Product';
        $this->key_cache = 'product';
    }

    use ProductTrait;
    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $this->method_cache = 'GetItemsForAdmin';
        $this->tags_cache = ['product', 'page', $page];
        $products = $this->GetOrCreateItemFromCache();

        $i = 0;
        $count = count($products);
        $this->model_cache = 'ProductCategory';
        $this->method_cache = 'GetCategoriesItem';
        $this->key_cache = 'product_categories';
        while ($i < $count) {
            $this->tags_cache = ['product_categories', 'item', $products[$i]->id];
            $this->parameters_cache = [$products[$i]->id];
            $products[$i]->categories = $this->GetOrCreateItemFromCache();
            $i++;
        }
        $data = (object)[
            'title' => 'Управление товарами',
            'route_name' => $this->route_name,
            'tree' => Category::GetTree(null, 'select_multiple'),
            'products' => $products
        ];
        return view('admin.items.painting.main', ['page' => $data]);
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
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'tree' => Category::GetTree(null, 'select_multiple', false),
            'size' => $size,
            'color' => $filter_by_color
        ];
        return view('admin.items.painting.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:products,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->parameters_cache = [$id];

        $this->tags_cache = ['product', 'item', $id];
        $this->method_cache = 'GetItem';
        $product = $this->GetOrCreateItemFromCache();

        $this->tags_cache = ['product_data', 'item', $id];
        $this->method_cache = 'GetDataLocalization';
        $this->key_cache = 'product_data';
        $data_product = $this->GetOrCreateItemFromCache();

        $this->method_cache = 'GetFilterColors';
        $this->tags_cache = ['active_colors_product', 'item', $id];
        $this->key_cache = 'active_colors_product';
        $active_colors = $this->PrepareActiveData($this->GetOrCreateItemFromCache(), 'color');

        $this->method_cache = 'GetSizes';
        $this->tags_cache = ['active_sizes_product', 'item', $id];
        $this->key_cache = 'active_sizes_product';
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

        $categories = $this->PrepareActiveData(Product::GetCategories($id), 'category');

        $data = (object)[
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'item_id' => $id,
            'product' => $product,
            'data' => $this->PrepareDataLocal($data_product),
            'tree' => Category::GetTree($categories, 'select_multiple'),
            'size' => $default_size,
            'color' => $filter_by_color,
            'active_color' => $active_colors,
            'active_size' => $active_sizes,
        ];
        return view('admin.items.painting.work_on', ['page' => $data]);
    }

    public function Add(AddOrUpdateRequest $request) {
        $date = Carbon::now()->toDateString();
        $path = public_path('assets/images/products/' . $date);
        File::makeDirectory($path, $mode = 0777, true, true);
        $exp = $request->file('image')->getClientOriginalExtension();
        $image = uniqid('img_').'.'.$exp;
        $request->file('image')->move(public_path('assets/images/products/'.$date.'/'), $image);

        $preview_image = $this->image_intervention->CreatePreview(
            'assets/images/products/'.$date.'/'.$image,
            'assets/images/products/'.$date.'/',
            $exp, 580, 435
        );

        $item_id = Product::CreateItem($request->vendor_code,
                                       $date.'/'.$image, $date.'/'.$preview_image,
                                       $request->min_width,
                                       $request->max_width,
                                       $request->min_height,
                                       $request->max_height,
                                       $request->status);

        ProductModularImage::CreateItemStatic($this->CreateModularImages($date,$item_id,$image,$exp));

        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            $meta_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $meta_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $meta_keywords  = $request['meta_keywords_'.$this->active_local[$i]->lang];
            $tags = $request['tags_'.$this->active_local[$i]->lang];

            DataProduct::CreateItem($item_id, $this->active_local[$i]->id, $name,
                $meta_title, $meta_description, $meta_keywords, $tags);
            $i++;
        }

        ProductCategory::CreateItems($item_id, $request->category);
        ProductSize::CreateItems($item_id, $request->size);
        if (isset($request->color)) {
            ProductFilterByColor::CreateItems($item_id, $request->color);
        }

        $this->tags_cache = ['product', 'page'];
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
        $item = Product::GetItem($request->item_id);
        if ($request->vendor_code != $item->vendor_code) {
            $validator = Validator::make(
                ['vendor_code' => $request->vendor_code],
                ['vendor_code' => 'unique:products,vendor_code']
            );
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
        }

        if (isset($request->image)) {
            Product::DeleteModularImages($request->item_id);
            $this->image_intervention->DeleteImages('/assets/images/products/', [
                $item->image, $item->preview_image
            ]);

            $date = Carbon::now()->toDateString();
            $path = public_path('assets/images/products/' . $date);
            File::makeDirectory($path, $mode = 0777, true, true);
            $exp = $request->file('image')->getClientOriginalExtension();
            $image = uniqid('img_').'.'.$exp;
            $request->file('image')->move(public_path('assets/images/products/'.$date.'/'), $image);

            $preview_image = $this->image_intervention->CreatePreview(
                'assets/images/products/'.$date.'/'.$image,
                'assets/images/products/'.$date.'/',
                $exp, 580, 435
            );
            ProductModularImage::CreateItemStatic($this->CreateModularImages($date,$request->item_id,$image,$exp));


            Product::UpdateItem($request->item_id, $request->vendor_code,
                $date.'/'.$image, $date.'/'.$preview_image, $request->min_width,
                $request->max_width, $request->min_height, $request->max_height, $request->status);

            $this->tags_cache = ['product', 'item', $request->item_id];
            $this->ForgetItemInCache();
        }
        else {
            Product::UpdateItem($request->item_id, $request->vendor_code,
                null, null, $request->min_width,
                $request->max_width, $request->min_height, $request->max_height, $request->status);

            $this->tags_cache = ['product', 'item', $request->item_id];
            $this->ForgetItemInCache();
        }
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            $meta_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $meta_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $meta_keywords  = $request['meta_keywords_'.$this->active_local[$i]->lang];
            $tags = $request['tags_'.$this->active_local[$i]->lang];

            DataProduct::UpdateItem($request->item_id, $this->active_local[$i]->id, $name,
                $meta_title, $meta_description, $meta_keywords, $tags);
            $i++;
        }

        $this->tags_cache = ['product', 'page'];
        $this->ForgetItemsOfPaginate();

        $this->tags_cache = ['product_data', 'item', $request->item_id];
        $this->key_cache = 'product_data';
        $this->ForgetItemInCache();

        $this->tags_cache = ['product_categories', 'item', $request->item_id];
        $this->key_cache = 'product_categories';
        $this->ForgetItemInCache();

        Product::DeleteCategories($request->item_id);
        Product::DeleteFilterColors($request->item_id);
        Product::DeleteSizes($request->item_id);

        ProductCategory::CreateItems($request->item_id, $request->category);


        ProductSize::CreateItems($request->item_id, $request->size);
        $this->tags_cache = ['active_sizes_product', 'item', $request->item_id];
        $this->key_cache = 'active_sizes_product';
        $this->ForgetItemInCache();

        if (isset($request->color)) {
            ProductFilterByColor::CreateItems($request->item_id, $request->color);

            $this->tags_cache = ['active_colors_product', 'item', $request->item_id];
            $this->key_cache = 'active_colors_product';
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
            ['id' => 'required|integer|exists:products,id']
        );
        if ($validator->fails()) {
            return redirect()->route('admin/paintings')->withErrors($validator);
        }

        Product::DeleteData($id);
        Product::DeleteCategories($id);
        Product::DeleteFilterColors($id);
        Product::DeleteSizes($id);
        Product::DeleteModularImages($id);
        Product::DeleteComments($id);
        Product::DeleteReviews($id);
        Product::DeleteItem($id);

        $this->tags_cache = ['product', 'page'];
        $this->ForgetItemsOfPaginate();

        $this->tags_cache = ['product', 'item', $id];
        $this->ForgetItemInCache();
        $this->tags_cache = ['product_data', 'item', $id];
        $this->key_cache = 'product_data';
        $this->ForgetItemInCache();
        $this->tags_cache = ['active_colors_product', 'item', $id];
        $this->key_cache = 'active_colors_product';
        $this->ForgetItemInCache();
        $this->tags_cache = ['active_sizes_product', 'item', $id];
        $this->key_cache = 'active_sizes_product';
        $this->ForgetItemInCache();
        $this->tags_cache = ['product_comment', 'page'];
        $this->ForgetItemsOfPaginate();
        $this->tags_cache = ['product_review', 'page'];
        $this->ForgetItemsOfPaginate();
        $this->tags_cache = ['recommend_product', 'page'];
        $this->ForgetItemsOfPaginate();



        return redirect()->route('admin/paintings')->with('success', 'Товар успешно удален');
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

        $products = Product::Search($request);
        $i = 0;
        $count = count($products);
        while ($i < $count) {
            $products[$i]->categories = ProductCategory::GetCategoriesItem($products[$i]->id);
            $i++;
        }
        $tree = Category::GetTree(null, 'select_multiple');
        if ($request->has('category')) {
            $tree = Category::GetTree($request->category, 'select_multiple');
        }
        $data = (object)[
            'title' => 'Поиск товаров',
            'route_name' => $this->route_name,
            'tree' => $tree,
            'products' => $products,
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
        return view('admin.items.painting.main', ['page' => $data]);
    }
}
