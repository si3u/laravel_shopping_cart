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

class ProductController extends Controller {
    private $image_intervention;

    public function __construct() {
        parent::__construct();

        $this->image_intervention = new Image();
    }

    use ProductTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Page() {
        $products = Product::GetItemsForAdmin();
        $i = 0;
        $count = count($products);
        while ($i < $count) {
            $products[$i]->categories = ProductCategory::GetCategoriesItem($products[$i]->id);
            $i++;
        }
        $data = (object)[
            'title' => 'Управление товарами',
            'route_name' => $this->route_name,
            'tree' => Category::GetTree(null, 'select_multiple'),
            'products' => $products
        ];
        return view('admin.product.main', ['page' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'tree' => Category::GetTree(null, 'select_multiple', false),
            'size' => DefaultSize::GetItemsStatic(),
            'color' => FilterByColor::GetItemsStatic()
        ];
        return view('admin.product.work_on', ['page' => $data]);
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
        return view('admin.product.main', ['page' => $data]);
    }

    /**
     * @param AddOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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
        return response()->json([
            'status' => 'success',
            'item_id' => $item_id,
            'preview_image' => $date.'/'.$preview_image
        ]);
    }

    /**
     * @param AddOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Update(AddOrUpdateRequest $request) {
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

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:products,id']
        );
        if ($validator->fails()) {
            return redirect()->route('admin/products')->withErrors($validator);
        }

        Product::DeleteData($id);
        Product::DeleteCategories($id);
        Product::DeleteFilterColors($id);
        Product::DeleteSizes($id);
        Product::DeleteModularImages($id);
        Product::DeleteComments($id);
        Product::DeleteReviews($id);
        Product::DeleteItem($id);

        return redirect()->route('admin/products')->with('success', 'Товар успешно удален');
    }
}