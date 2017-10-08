<?php

namespace App\Http\Controllers\Admin;

use App\FilterByColor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterByColor\AddRequest;
use App\Http\Requests\Admin\FilterByColor\DeleteRequest;
use App\Traits\Controllers\Admin\FilterByColorTrait;

class FilterByColorController extends Controller {

    use FilterByColorTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Page() {
        $data = (object)[
            'title' => 'Управление фильтрами | Цвет',
            'route_name' => $this->route_name,
            'colors' => $this->GetItemsFromCache()
        ];
        return view('admin.filters.colors', ['page' => $data]);
    }

    /**
     * @param AddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Add(AddRequest $request)  {
        $this->ForgetItemsInCache();
        return response()->json([
            'status' => 'success',
            'item_id' => FilterByColor::CreateItem($request->name, $request->hex)
        ]);
    }

    public function Delete(DeleteRequest $request) {
        if (FilterByColor::DeleteItem($request->id)) {
            $this->ForgetItemsInCache();
            return response()->json([
                'status' => 'success',
            ]);
        }
    }
}