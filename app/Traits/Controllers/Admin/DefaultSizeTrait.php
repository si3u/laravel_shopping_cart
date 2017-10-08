<?php
namespace App\Traits\Controllers\Admin;

use App\DefaultSize;
use Illuminate\Support\Facades\Cache;

trait DefaultSizeTrait {
	private function GetItemFromCache() {
		return Cache::rememberForever('default_size', function() {
            return DefaultSize::GetItems();
        });
	}

	private function ForgetItemInCache() {
		Cache::forget('default_size');
	}
}