<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\DefaultSize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class DefaultSizeController extends Controller {
    private $active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
    }

    public function Page() {
        $data = (object)[
            'title' => 'Список размеров картин',
            'route_name' => $this->route_name,
            'size' => DefaultSize::GetItems()
        ];
        return view('admin.default_sizes.main', ['page' => $data]);
    }

    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'width' => 'required|integer',
            'height' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        return response()->json([
            'status' => 'success',
            'item_id' => DefaultSize::CreateItem($request->width, $request->height)
        ]);
    }

    public function Delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:default_sizes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        DefaultSize::DeleteItem($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }
}