<?php

namespace App\Http\Controllers\Admin;

use App\DefaultSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DefaultSize\AddRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DefaultSizeController extends Controller {
    public function Page() {
        $data = (object)[
            'title' => 'Список размеров картин',
            'route_name' => $this->route_name,
            'size' => DefaultSize::GetItems()
        ];
        return view('admin.default_sizes.main', ['page' => $data]);
    }

    public function Add(AddRequest $request) {
        /*$validator = Validator::make($request->all(), [
            'width' => 'required|integer',
            'height' => 'required|integer'
        ]);*/

        /*if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }*/
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