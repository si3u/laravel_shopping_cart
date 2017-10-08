<?php
namespace App\Traits\Controllers\Admin;

use App\FilterByColor;
use Illuminate\Support\Facades\Cache;

trait FilterByColorTrait {
    public function GetItemsFromCache() {
        return Cache::rememberForever('filter_by_color', function() {
            return FilterByColor::GetItems();
        });
    }
    
    public function ForgetItemsInCache() {
        Cache::forget('filter_by_color');
    }
}