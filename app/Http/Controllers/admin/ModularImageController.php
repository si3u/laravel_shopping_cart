<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModularImage\AddRequest;
use App\ModularImage;
use Illuminate\Support\Facades\Validator;

class ModularImageController extends Controller
{
    private $image_intervention;

    public function __construct() {
        parent::__construct();
        $this->image_intervention = new Image();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Page() {
        $data = (object)[
            'title' => 'Управление модулями',
            'modular' => ModularImage::GetItems()
        ];
        return view('admin.modular_image.main', ['page' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление модулей'
        ];
        return view('admin.modular_image.work_on', ['page' => $data]);
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param AddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Add(AddRequest $request) {
        $exp = $request->file('file')->getClientOriginalExtension();
        $image = uniqid('img_').'.'.$exp;
        $request->file('file')->move(public_path('assets/images/modular/'), $image);
        $preview_image = $this->image_intervention->CreatePreview(
            'assets/images/modular/'.$image,
            'assets/images/modular/',
            $exp, 360, 270, '#4169E0'
        );
        ModularImage::CreateItem($image, $preview_image);
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
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