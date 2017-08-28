<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModularImage\AddRequest;
use App\ImageBase\ImageBase;
use App\ModularImage;
use Illuminate\Support\Facades\Validator;

class ModularImageController extends Controller
{
    public function Page() {
        $data = (object)[
            'title' => 'Управление модулями',
            'modular' => ModularImage::GetItems()
        ];
        return view('admin.modular_image.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление модулей'
        ];
        return view('admin.modular_image.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:modular_images,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = (object)[
            'title' => 'Редактирование модуля',
            'item' => ModularImage::GetItem($id)
        ];
        return view('admin.modular_image.update', ['page' => $data]);
    }

    public function Add(AddRequest $request) {
        $exp = $request->file('file')->getClientOriginalExtension();
        $image = uniqid('img_').'.'.$exp;
        $request->file('file')->move(public_path('assets/images/modular/'), $image);
        $preview_image = ImageBase::CreatePreview(
            'assets/images/modular/'.$image,
            'assets/images/modular/',
            $exp, 360, 270, '#4169E0'
        );
        ModularImage::CreateItem($image, $preview_image);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:modular_images,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        ModularImage::DeleteItem($id);
        return redirect()->back()->with('success', 'Модуль успешно удален');
    }
}