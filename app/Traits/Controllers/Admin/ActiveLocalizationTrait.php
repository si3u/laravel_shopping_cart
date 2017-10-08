<?php
namespace App\Traits\Controllers\Admin;

use App\ActiveLocalization;
use Illuminate\Support\Facades\Cache;

trait ActiveLocalizationTrait {

    private function ForgetItemsOfCache() {
        Cache::tags(['active_local', 'all'])->forget('active_local');
        Cache::tags(['active_local', 'active'])->forget('active_local');
    }

    private function GetItemsFromCache($option) {
        if ($option === 'all') {
            return Cache::tags(['active_local', 'all'])->rememberForever('active_local', function () {
                return ActiveLocalization::GetAll();
            });
        }
        if ($option === 'active') {
            return Cache::tags(['active_local', 'active'])->rememberForever('active_local', function () {
                return ActiveLocalization::GetActive();
            });
        }
    }
}