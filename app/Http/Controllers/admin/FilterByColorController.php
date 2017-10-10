<?php

namespace App\Http\Controllers\Admin;

use App\FilterByColor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterByColor\AddRequest;
use App\Http\Requests\Admin\FilterByColor\DeleteRequest;
use App\Traits\CacheTrait;

class FilterByColorController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'FilterByColor';
        $this->key_cache = 'filter_by_color';
        $this->method_cache = 'GetItems';
    }

    use CacheTrait;

    public function Page() {
        $data = (object)[
            'title' => 'Управление фильтрами | Цвет',
            'route_name' => $this->route_name,
            'colors' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.filters.colors', ['page' => $data]);
    }
    
    public function Add(AddRequest $request)  {
        $this->ForgetItemInCache();
        return response()->json([
            'status' => 'success',
            'item_id' => FilterByColor::CreateItem($request->name, $request->hex)
        ]);
    }

    public function Delete(DeleteRequest $request) {
        if (FilterByColor::DeleteItem($request->id)) {
            $this->ForgetItemInCache();
            return response()->json([
                'status' => 'success',
            ]);
        }
    }
}