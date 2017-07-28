<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Category;
use App\DataCategory;
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
        $active_lang = ActiveLocalization::GetActive();
        $data = [
            'title' => 'Добавить категорию',
            'route_name' => $this->route_name,
            'active_lang' => $active_lang,
            'parents' => Category::GetTree(1,1)
        ];
        return view('admin.categories.work_on', ['page' => (object)$data]);
    }

    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'item_id' => 'integer|nullable',
            'lang_id' => 'required|integer|exists:active_localizations,id',
            'name' => 'required|string',
            'slug' => 'string|nullable',
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
        if (isset($request->item_id)) {
            if (DataCategory::CreateItem($request->item_id,
                                         $request->name,
                                         $request->lang_id,
                                         $request->description,
                                         $request->meta_title,
                                         $request->meta_description,
                                         $request->meta_keywords)) {
                $result = [
                    'status' => 'success',
                    'item_id' => $request->id,
                    'parents' => Category::GetTree($request->parent_id, 1)
                ];
                return response()->json($result);
            }
            return response()->json([
                'status' => 'error'
            ]);
        } else {
            if (Category::CreateItem($request->slug,
                                     $request->parent_id,
                                     $request->sorting_order)) {
                $last_id = Category::GetLastItem()->id;
                if (DataCategory::CreateItem($last_id,
                                             $request->name,
                                             $request->lang_id,
                                             $request->description,
                                             $request->meta_title,
                                             $request->meta_description,
                                             $request->meta_keywords)) {
                    $result = [
                        'status' => 'success',
                        'item_id' => $last_id,
                        'parents' => Category::GetTree($request->parent_id, 1)
                    ];
                    return response()->json($result);
                }
            }
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}