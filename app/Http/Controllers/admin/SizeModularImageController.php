<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SizeModularImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeModularImageController extends Controller {
    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'modular_id' => 'required|integer|exists:modular_images,id',
            'number' => 'required|integer',
            'width' => 'required|integer',
            'height' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
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

    public function Delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:size_modular_images,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        SizeModularImage::DeleteItem($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }
}