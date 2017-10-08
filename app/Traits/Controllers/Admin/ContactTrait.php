<?php
namespace App\Traits\Controllers\Admin;

use App\Contact;
use Illuminate\Support\Facades\Cache;

trait ContactTrait {
	
	private function GetItemFromCache() {
		return Cache::rememberForever('contact', function () {
            return Contact::GetData();
        });
	}

	private function ForgetItemInCache() {
		Cache::forget('contact');
	}
}