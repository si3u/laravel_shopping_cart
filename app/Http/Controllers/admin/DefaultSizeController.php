<?php

namespace App\Http\Controllers\Admin;

use App\DefaultSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DefaultSize\AddRequest;
use App\Http\Requests\Admin\DefaultSize\DeleteRequest;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class DefaultSizeController extends Controller {

    use CacheTrait;

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'DefaultSize';
        $this->method_cache = 'GetItems';
        $this->key_cache = 'default_size';
    }

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $data = (object)[
            'title' => 'Список размеров картин',
            'route_name' => $this->route_name,
            'size' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.default_sizes.main', ['page' => $data]);
    }

    public function Add(AddRequest $request) {
        $item_id = DefaultSize::CreateItem($request->width, $request->height);

        $this->ForgetItemInCache();

        return response()->json([
            'status' => 'success',
            'item_id' => $item_id
        ]);
    }

    public function Delete(DeleteRequest $request) {
        DefaultSize::DeleteItem($request->id);

        $this->ForgetItemInCache();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
