<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModularImage\AddRequest;
use App\ModularImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\CacheTrait;

class ModularImageController extends Controller
{
    private $image_intervention;

    public function __construct() {
        parent::__construct();

        $this->image_intervention = new Image();

        $this->model_cache = 'ModularImage';
        $this->key_cache = 'modular_images';
    }

    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $this->method_cache = 'GetItems';
        $this->tags_cache = ['modular_images', 'page', $page];

        $data = (object)[
            'title' => 'Управление модулями',
            'modular' => $this->GetOrCreateItemFromCache()
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

        $this->method_cache = 'GetItem';
        $this->tags_cache = ['modular_images', 'item', $id];
        $this->parameters_cache = [$id];

        $data = (object)[
            'title' => 'Редактирование модуля',
            'item' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.modular_image.update', ['page' => $data]);
    }

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
        
        $this->tags_cache = ['modular_images', 'page'];
        $this->ForgetItemsOfPaginate();

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

        $this->tags_cache = ['modular_images', 'page'];
        $this->ForgetItemsOfPaginate();
        $this->tags_cache = ['modular_images', 'item', $id];
        $this->ForgetItemInCache();

        return redirect()->back()->with('success', 'Модуль успешно удален');
    }
}