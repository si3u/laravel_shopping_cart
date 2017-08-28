<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeModularImage\AddRequest;
use App\Http\Requests\Admin\SizeModularImage\DeleteRequest;
use App\SizeModularImage;

class SizeModularImageController extends Controller {
    public function Add(AddRequest $request) {
        $count_number = SizeModularImage::CountNumber($request->modular_id, $request->number);
        if ($count_number > 0) {
            return response()->json([
                'error' => 'Этот порядковый номер уже существует у этого модуля'
            ]);
        }
        $id = SizeModularImage::CreateItem($request->modular_id, $request->number, $request->width, $request->height);
        return response()->json([
            'status' => 'success',
            'item_id' => $id
        ]);
    }

    public function Delete(DeleteRequest $request) {
        SizeModularImage::DeleteItem($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }
}