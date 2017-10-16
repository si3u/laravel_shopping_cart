<?php

namespace App\Http\Controllers;

use App\ActiveLocalization;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use CacheTrait;

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

    protected $controller_lang_id;
    protected $current_controller;

    public function __construct() {
        $this->parameters_cache = [];

        $this->key_cache = 'active_local';
        $this->model_cache = 'ActiveLocalization';
        $this->method_cache = 'GetActive';
        $this->tags_cache = ['active_local', 'active'];

        $this->active_local = $this->GetOrCreateItemFromCache();

        $this->key_cache = null;
        $this->model_cache = null;
        $this->method_cache = null;
        $this->tags_cache = null;

        $this->route_name = \Route::currentRouteName();

        $this->count_active_local = count($this->active_local);
        $i = 0;
        while ($i < $this->count_active_local) {
            $this->active_local_id[] = $this->active_local[$i]->id;
            $i++;
        }

        $this->current_controller = preg_replace('/.*\\\/', '', explode('@', \Route::currentRouteAction()))[0];

        switch (app()->getLocale()) {
            case 'ru':
                $this->controller_lang_id = 1;
            break;
            case 'ua':
                $this->controller_lang_id = 2;
            break;
            case 'en':
                $this->controller_lang_id = 3;
            break;
            default:
                $this->controller_lang_id = 1;
        }
    }
}
