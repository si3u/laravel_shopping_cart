<?php
namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheTrait {
	private function ExistItemInCache() {
        return Cache::tags($this->tags_cache)->has($this->key_cache);
    }

    private function GetItemFromCache() {
        return Cache::tags($this->tags_cache)->get($this->key_cache);
    }

    private function CreateItemFromCahe() {
        return Cache::tags($this->tags_cache)->rememberForever($this->key_cache, function () {
            return call_user_func_array('App\\'.$this->model_cache.'::'.$this->method_cache, $this->parameters_cache);
        });
    }

    private function ForgetItemInCache() {
        Cache::tags($this->tags_cache)->forget($this->key_cache);
    }

    private function GetItemsFromPaginate() {
        return Cache::tags($this->tags_cache)
		        ->rememberForever($this->key_cache, function() {
		            return call_user_func_array(
		            	'App\\'.$this->model_cache.'::'.$this->method_cache, 
		            	$this->parameters_cache
		            );
		        });
    }
    
    private function ForgetItemsOfPaginate() {
        Cache::tags($this->tags_cache)->flush();
    }


}