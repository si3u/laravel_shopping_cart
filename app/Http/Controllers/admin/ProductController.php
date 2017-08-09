<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Category;
use App\DataProduct;
use App\DefaultSize;
use App\FilterByColor;
use App\Http\Controllers\Controller;
use App\ImageBase\ImageBase;
use App\Product;
use App\ProductCategory;
use App\ProductFilterByColor;
use App\ProductSize;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller {
    private $active_local;
    private $active_local_id;
    private $count_active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
        $this->count_active_local = count($this->active_local);
        $i = 0;
        while ($i < $this->count_active_local) {
            $this->active_local_id[] = $this->active_local[$i]->id;
            $i++;
        }
    }

    private function PrepareActiveData($data, $option) {
        $i = 0;
        $count = count($data);
        $result = [];
        while ($i < $count) {
            switch ($option) {
                case 'category':
                    $result[] = $data[$i]->category_id;
                    break;
                case 'color':
                    $result[] = $data[$i]->color_id;
                    break;
                case 'size':
                    $result[] = $data[$i]->size_id;
                    break;
            }
            $i++;
        }
        return $result;
    }

    private function PrepareDataLocal($id) {
        $data_local = Product::GetDataLocalization($id);
        $prepare_data_local = null;
        foreach ($data_local as $item) {
            $key = '';
            switch ($item->lang_id) {
                case 1:
                    $key = 'ru';
                    break;
                case 2:
                    $key = 'ua';
                    break;
                case 3:
                    $key = 'en';
                    break;
            }
            $prepare_data_local[$key] = (object)[
                'name' => $item->name,
                'meta_title' => $item->meta_title,
                'meta_description' => $item->meta_description,
                'meta_keywords' => $item->meta_keywords,
                'tags' => $item->tags,
            ];
        }
        return (object)$prepare_data_local;
    }

    public function Page() {
        $products = Product::GetItemsForAdmin();
        /*$prepare_data = [];
        $i = 0;
        $count = count($products);
        while ($i < $count) {
            $status = false;
            $j = 0;
            while ($j < count($prepare_data)) {
                if ($products[$i]->id == $prepare_data[$j]['id']) {
                    $status = true;
                }
                $j++;
            }
            if (!$status) {
                array_push($prepare_data, [
                    'id' => $products[$i]->id,
                    'vendor_code' => $products[$i]->vendor_code,
                    'preview_image' => $products[$i]->preview_image,
                    'status' => $products[$i]->status,
                    'categories' => []
                ]);
            }
            $status = false;
            $i++;
        }

        $i = 0;
        while($i < $count) {
            $j = 0;
            $count_prepare = count($prepare_data);
            while($j < $count_prepare) {
                if ($products[$i]->id == $prepare_data[$j]['id']) {
                    array_push($prepare_data[$j]['categories'], [
                        'id' => $products[$i]->category_id,
                        'name' => $products[$i]->category_name,
                    ]);
                }
                $j++;
            }
            $i++;
        }*/
        $i = 0;
        $count = count($products);
        while ($i < $count) {
            $products[$i]->categories = ProductCategory::GetCategoriesItem($products[$i]->id);
            $i++;
        }
        $data = (object)[
            'title' => 'Управление товарами',
            'products' => $products
        ];
        return view('admin.product.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'tree' => Category::GetTree(1, 'select_multiple'),
            'size' => DefaultSize::GetItemsStatic(),
            'color' => FilterByColor::GetItemsStatic()
        ];
        return view('admin.product.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:products,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $categories = $this->PrepareActiveData(Product::GetCategories($id), 'category');
        $colors = $this->PrepareActiveData(Product::GetFilterColors($id), 'color');
        $sizes = $this->PrepareActiveData(Product::GetSizes($id), 'size');

        $data = (object)[
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'item_id' => $id,
            'product' => Product::GetItem($id),
            'data' => $this->PrepareDataLocal($id),
            'tree' => Category::GetTree($categories, 'select_multiple'),
            'size' => DefaultSize::GetItemsStatic(),
            'color' => FilterByColor::GetItemsStatic(),
            'active_color' => $colors,
            'active_size' => $sizes,
        ];
        return view('admin.product.work_on', ['page' => $data]);
    }

    public function Add(Request $request) {
        $i = 0;
        while ($i<$this->count_active_local) {
            $validator = Validator::make($request->all(), [
                    'name_'.$this->active_local[$i]->lang => 'required|string|min:1|max:255',
                    'meta_title_'.$this->active_local[$i]->lang => 'string|max:255|nullable',
                    'meta_description_'.$this->active_local[$i]->lang => 'string|nullable',
                    'meta_keywords_'.$this->active_local[$i]->lang => 'string|nullable',
                    'tags_'.$this->active_local[$i]->lang => 'string|nullable'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        $validator = Validator::make($request->all(), [
            'vendor_code' => 'required|integer|unique:products,vendor_code',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'min_width' => 'required|integer',
            'max_width' => 'required|integer',
            'min_height' => 'required|integer',
            'max_height' => 'required|integer',
            'category' => 'required',
            'category.*' => 'required|integer|exists:categories,id',
            'size' => 'required',
            'size.*' => 'required|integer|exists:default_sizes,id',
            'color.*' => 'nullable|integer|exists:filter_by_colors,id',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        if (in_array(1, $request->category)) {
            return response()->json([
                'error' => 'Уберите с списка категорий "Корневая категория"'
            ]);
        }
        $date = Carbon::now()->toDateString();
        $path = public_path('assets/images/products/' . $date);
        File::makeDirectory($path, $mode = 0777, true, true);
        $exp = $request->file('image')->getClientOriginalExtension();
        $image = uniqid('img_').'.'.$exp;
        $request->file('image')->move(public_path('assets/images/products/'.$date.'/'), $image);

        $preview_image = ImageBase::CreatePreview(
            'assets/images/products/'.$date.'/'.$image,
            'assets/images/products/'.$date.'/',
            $exp, 300, 300
        );

        $item_id = Product::CreateItem($request->vendor_code, $date.'/'.$image, $date.'/'.$preview_image, $request->min_width,
            $request->max_width, $request->min_height, $request->max_height, $request->status);

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
        return response()->json([
            'status' => 'success',
            'item_id' => $item_id,
            'preview_image' => $date.'/'.$preview_image
        ]);
    }

    public function Update(Request $request) {
        $i = 0;
        while ($i<$this->count_active_local) {
            $validator = Validator::make($request->all(), [
                'name_'.$this->active_local[$i]->lang => 'required|string|min:1|max:255',
                'meta_title_'.$this->active_local[$i]->lang => 'string|max:255|nullable',
                'meta_description_'.$this->active_local[$i]->lang => 'string|nullable',
                'meta_keywords_'.$this->active_local[$i]->lang => 'string|nullable',
                'tags_'.$this->active_local[$i]->lang => 'string|nullable'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|integer|exists:products,id',
            'vendor_code' => 'required|integer',
            'image' => 'mimes:jpg,jpeg,png|max:2048',
            'min_width' => 'required|integer',
            'max_width' => 'required|integer',
            'min_height' => 'required|integer',
            'max_height' => 'required|integer',
            'category' => 'required',
            'category.*' => 'required|integer|exists:categories,id',
            'size' => 'required',
            'size.*' => 'required|integer|exists:default_sizes,id',
            'color.*' => 'nullable|integer|exists:filter_by_colors,id',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
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
            ImageBase::DeleteImages('/assets/images/products/', [
                $item->image, $item->preview_image
            ]);

            $date = Carbon::now()->toDateString();
            $path = public_path('assets/images/products/' . $date);
            File::makeDirectory($path, $mode = 0777, true, true);
            $exp = $request->file('image')->getClientOriginalExtension();
            $image = uniqid('img_').'.'.$exp;
            $request->file('image')->move(public_path('assets/images/products/'.$date.'/'), $image);

            $preview_image = ImageBase::CreatePreview(
                'assets/images/products/'.$date.'/'.$image,
                'assets/images/products/'.$date.'/',
                $exp, 300, 300
            );

            Product::UpdateItem($request->item_id, $request->vendor_code,
                $date.'/'.$image, $date.'/'.$preview_image, $request->min_width,
                $request->max_width, $request->min_height, $request->max_height, $request->status);
        }
        else {
            Product::UpdateItem($request->item_id, $request->vendor_code,
                null, null, $request->min_width,
                $request->max_width, $request->min_height, $request->max_height, $request->status);
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

        Product::DeleteCategories($request->item_id);
        Product::DeleteFilterColors($request->item_id);
        Product::DeleteSizes($request->item_id);

        ProductCategory::CreateItems($request->item_id, $request->category);
        ProductSize::CreateItems($request->item_id, $request->size);
        if (isset($request->color)) {
            ProductFilterByColor::CreateItems($request->item_id, $request->color);
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
}