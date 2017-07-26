<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller {
    private $route_name;

    public function __construct() {
        $this->route_name = Route::currentRouteName();
    }

    public function Page() {
        $data = (object)[
            'title' => 'Список категорий',
        ];
        return view('admin.categories.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавить категорию',
            'route_name' => $this->route_name,
        ];
        return view('admin.categories.work_on', ['page' => $data]);
    }

    public function PageUpdate() {
        $data = (object)[
            'title' => 'Изменить категорию',
            'route_name' => $this->route_name,
        ];
        return view('admin.categories.work_on', ['page' => $data]);
    }

    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:255',
            'sorting_order' => 'required|integer',
            'description' => 'string|nullable',
            'parent_id' => 'string|nullable',
            'meta_title' => 'string|nullable',
            'meta_description' => 'string|nullable',
            'meta_keywords' => 'string|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        if (Category::AddItem($request->name,
                              $request->description,
                              $request->meta_title,
                              $request->meta_description,
                              $request->meta_keywords)) {
            return response()->json([
                'status' => 'success',
                'item_id' => Category::GetLastItemId()->id
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);
    }
}