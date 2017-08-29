<?php

namespace App\Http\Controllers\Admin;

use App\DefaultSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DefaultSize\AddRequest;
use App\Http\Requests\Admin\DefaultSize\DeleteRequest;

class DefaultSizeController extends Controller {
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Page() {
        $data = (object)[
            'title' => 'Список размеров картин',
            'route_name' => $this->route_name,
            'size' => DefaultSize::GetItems()
        ];
        return view('admin.default_sizes.main', ['page' => $data]);
    }

    /**
     * @param AddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Add(AddRequest $request) {
        return response()->json([
            'status' => 'success',
            'item_id' => DefaultSize::CreateItem($request->width, $request->height)
        ]);
    }

    /**
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete(DeleteRequest $request) {
        DefaultSize::DeleteItem($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }
}