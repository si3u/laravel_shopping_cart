<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecommendProduct\CommonRequest;
use App\ProductCategory;
use App\RecommendProduct;

class RecommendProductController extends Controller {
    public function Page() {
        $products = RecommendProduct::GetItems();
        $i = 0;
        $count = count($products);
        while ($i < $count) {
            $products[$i]->categories = ProductCategory::GetCategoriesItem($products[$i]->id);
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
    public function Add(CommonRequest $request) {
        $this->Check();
        RecommendProduct::CreateItems($request->check_products);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Delete(CommonRequest $request) {
        $this->Check();
        RecommendProduct::DeleteItems($request->check_products);
        return redirect()->back()->with('success', 'выбранные товары были удалены с рекомендуемых товаров');
    }
}