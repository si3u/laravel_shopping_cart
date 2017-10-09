<?php

namespace App\Http\Controllers;

use App\ActiveLocalization;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\Controllers\Admin\ActiveLocalizationTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ActiveLocalizationTrait;

    protected $active_local;
    protected $active_local_id;
    protected $count_active_local;
    protected $route_name;

    //cache
    protected $key_cache;
    protected $tags_cache;
    protected $model_cache;
    protected $method_cache;
    protected $parameters_cache;
    
    protected $current_controller;

    public function __construct() {
        $this->active_local = $this->GetItemsFromCache('active');
        $this->route_name = \Route::currentRouteName();
        $this->count_active_local = count($this->active_local);
        $i = 0;
        while ($i < $this->count_active_local) {
            $this->active_local_id[] = $this->active_local[$i]->id;
            $i++;
        }

        $this->current_controller = preg_replace('/.*\\\/', '', explode('@', \Route::currentRouteAction()))[0];

        $this->parameters_cache = [];
    }
}
