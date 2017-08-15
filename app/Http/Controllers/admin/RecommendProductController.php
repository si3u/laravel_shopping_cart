<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use App\RecommendProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'check_products.*' => 'nullable|integer'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        RecommendProduct::CreateItems($request->check_products);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'check_products.*' => 'integer|exists:recommend_products,product_id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if (!isset($request->check_products)) {
            return redirect()->back();
        }
        else {
            RecommendProduct::DeleteItems($request->check_products);
            return redirect()->back()->with('success', 'выбранные товары были удалены с рекомендуемых товаров');
        }
    }
}