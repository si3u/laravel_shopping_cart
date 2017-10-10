<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecommendProduct\CommonRequest;
use App\ProductCategory;
use App\RecommendProduct;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class RecommendProductController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'RecommendProduct';
        $this->key_cache = 'recommend_product';
    }

    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $this->method_cache = 'GetItems';
        $this->tags_cache = ['recommend_product', 'page', $page];

        $products = $this->GetOrCreateItemfromCache();

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
            'products' => $products
        ];
        return view('admin.product.main', ['page' => $data]);
    }

    private function Check() {
        if (!isset($request->check_products)) {
            return redirect()->back();
        }
    }

    private function ForgetItems() {
        $this->tags_cache = ['recommend_product', 'page'];
        $this->ForgetItemsOfPaginate();
    }

    public function Add(CommonRequest $request) {
        $this->Check();
        
        RecommendProduct::CreateItems($request->check_products);

        $this->ForgetItems();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Delete(CommonRequest $request) {
        $this->Check();
        
        RecommendProduct::DeleteItems($request->check_products);

        $this->ForgetItems();

        return redirect()->back()->with('success', 'выбранные товары были удалены с рекомендуемых товаров');
    }
}