<?php

namespace App\Http\Controllers\Admin;

use App\FilterByColor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterByColor\AddRequest;
use App\Http\Requests\Admin\FilterByColor\DeleteRequest;

class FilterByColorController extends Controller {
    public function Page() {
        $data = (object)[
            'title' => 'Управление фильтрами | Цвет',
            'route_name' => $this->route_name,
            'colors' => FilterByColor::GetItems()
        ];
        return view('admin.filters.colors', ['page' => $data]);
    }

    public function Add(AddRequest $request)  {
        return response()->json([
            'status' => 'success',
            'item_id' => FilterByColor::CreateItem($request->name, $request->hex)
        ]);
    }

    public function Delete(DeleteRequest $request) {
        if (FilterByColor::DeleteItem($request->id)) {
            return response()->json([
                'status' => 'success',
            ]);
        }
    }
}