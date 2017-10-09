<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CacheTrait;
use App\ActiveLocalization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActiveLocalizationController extends Controller {
    use CacheTrait;

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'ActiveLocalization';
        $this->key_cache = 'active_local';
        $this->parameters_cache = [];
    }

    public function Get() {
        $this->method_cache = 'GetAll';
        $this->tags_cache = ['active_local', 'all'];
        
        return response()->json($this->GetOrCreateItemFromCache());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetActive() {
        $this->method_cache = 'GetActive';
        $this->tags_cache = ['active_local', 'active'];

        return response()->json($this->GetOrCreateItemFromCache());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Update(Request $request) {
        $status = [false, false, false];
        if (isset($request->ru)) {
            $status[0] = true;
        }
        if (isset($request->ua)) {
            $status[1] = true;
        }
        if (isset($request->en)) {
            $status[2] = true;
        }
        if ($status[0] != true) {
            return response()->json([
                'error' => 'Русская локализация является основной локализацией. Выключить ее нельзя.'
            ]);
        }
        if (!in_array(true, array_values($status))) {
            return response()->json([
                'error' => 'Должна быть выбрана минимум одна локализация'
            ]);
        }
        if (ActiveLocalization::UpdateItem($status)) {
            
            $this->tags_cache = ['active_local', 'active'];
            $this->ForgetItemInCache();
            $this->tags_cache = ['active_local', 'all'];
            $this->ForgetItemInCache();
            
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}