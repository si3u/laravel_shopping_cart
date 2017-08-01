<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\FilterByColor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class FilterByColorController extends Controller {
    private $active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
    }

    public function Page() {
        $data = (object)[
            'title' => 'Управление фильтрами | Цвет',
            'route_name' => $this->route_name,
            'colors' => FilterByColor::GetItems()
        ];
        return view('admin.filters.colors', ['page' => $data]);
    }

    public function Add(Request $request)  {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:filter_by_colors,name',
            'hex' => 'required|string|max:255|unique:filter_by_colors,hex',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'item_id' => FilterByColor::CreateItem($request->name, $request->hex)
        ]);
    }

    public function Delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:filter_by_colors,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        if (FilterByColor::DeleteItem($request->id)) {
            return response()->json([
                'status' => 'success',
            ]);
        }
    }
}