<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecommendProduct extends Model
{
    public $timestamps = false;
    protected function CreateItems($products_id) {
        $i = 0; $count = count($products_id);
        $data = [];
        while ($i < $count) {
            $data[] = ['product_id' => $products_id[$i]];
            $i++;
        }
        RecommendProduct::insertOnDuplicateKey($data);
    }

    protected function GetItems() {
            return DB::table('recommend_products')
                ->join('products', 'recommend_products.product_id', '=', 'products.id')
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

    protected function DeleteItems($items) {
        return RecommendProduct::whereIn('product_id', $items)->delete();
    }
}
