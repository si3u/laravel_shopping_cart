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
            'parents' => Category::GetSelectCategories(1)
        ];
        return view('admin.categories.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make([
                'id' => $id
            ], [
                'id' => 'required|int|exists:categories,id',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        $item = Category::GetItem($id);
        $data = (object)[
            'title' => 'Изменить категорию',
            'route_name' => $this->route_name,
            'item' => $item,
            'parents' => Category::GetSelectCategories($item->parent_id)
        ];
        return view('admin.categories.work_on', ['page' => $data]);
    }

    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required|string|unique:categories,slug',
            'sorting_order' => 'required|integer',
            'description' => 'string|nullable',
            'parent_id' => 'required|integer|exists:categories,id',
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
                              $request->slug,
                              $request->description,
                              $request->meta_title,
                              $request->meta_description,
                              $request->meta_keywords,
                              $request->sorting_order,
                              $request->parent_id)) {
            return response()->json([
                'status' => 'success',
                'item_id' => Category::GetLastItemId()->id
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);
    }

    public function Update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exist:categories,id',
            'name' => 'required|string',
            'slug' => 'required|string',
            'sorting_order' => 'required|integer',
            'description' => 'string|nullable',
            'parent_id' => 'required|integer|exists:categories,id',
            'meta_title' => 'string|nullable',
            'meta_description' => 'string|nullable',
            'meta_keywords' => 'string|nullable',
        ]);
        if ($request->id == $request->parent_id) {
            return response()->json([
                'error' => 'Категория не может быть сама себе родительской категорией'
            ]);
        }
        if (Category::GetSlug($request->id)->slug != $request->slug) {
            if (Category::SearchSlug($request->slug)>0) {
                return response()->json([
                    'error' => 'Этот адресс уже занят'
                ]);
            }
        }
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        if (Category::Update($request->id,
                             $request->name,
                             $request->slug,
                             $request->description,
                             $request->meta_title,
                             $request->meta_description,
                             $request->meta_keywords,
                             $request->sorting_order,
                             $request->parent_id)) {
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);
    }
}