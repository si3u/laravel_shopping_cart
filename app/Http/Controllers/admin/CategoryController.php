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
    private $active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
    }
    private function PrepareDataLocal($id) {
        $data_local = Category::GetDataLocalization($id);
        $prepare_data_local = null;
        foreach ($data_local as $item) {
            if ($item->lang_id == 1) {
                $prepare_data_local['ru'] = (object)[
                    'name' => $item->name,
                    'description' => $item->description,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
                    'meta_keywords' => $item->meta_keywords,
                ];
            }
            elseif ($item->lang_id == 2) {
                $prepare_data_local['ua'] = (object)[
                    'name' => $item->name,
                    'description' => $item->description,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
                    'meta_keywords' => $item->meta_keywords,
                ];
            }
            else {
                $prepare_data_local['en'] = (object)[
                    'name' => $item->name,
                    'description' => $item->description,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
                    'meta_keywords' => $item->meta_keywords,
                ];
            }
        }
        return (object)$prepare_data_local;
    }


    public function Page() {
        $data = (object)[
            'title' => 'Древо категорий',
            'tree' => Category::GetTree(1, 'categories/main')
        ];
        return view('admin.categories.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = [
            'title' => 'Добавить категорию',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'parents' => Category::GetTree(1, 'add_or_update')
        ];
        return view('admin.categories.work_on', ['page' => (object)$data]);
    }

    public function PageUpdate($id) {
        if ($id == 1) {
            $error = 'Эту категорию изменить нельзя. 
            Она используется для идентификации категории 
            как родительская категория.';
            return redirect()->back()->withErrors($error);
        }

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:categories,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $category = Category::GetDataItem($id);

        $data = (object)[
            'title' => 'Изменение категории',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'parents' => Category::GetTree($category->parent_id, 'add_or_update'),
            'category' => $category,
            'data_local' => $this->PrepareDataLocal($id)
        ];

        return view('admin.categories.work_on', ['page' => $data]);
    }

    public function Add(Request $request) {
        $validator = Validator::make(
            ['parent_id' => $request->parent_id],
            ['parent_id' => 'required|integer|exists:categories,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        $i = 0;
        while ($i<count($this->active_local)) {
            $validator = Validator::make($request->all(), [
                'name_'.$this->active_local[$i]->lang => 'required|string',
                'sorting_order_'.$this->active_local[$i]->lang => 'required|integer',
                'description_'.$this->active_local[$i]->lang => 'string|nullable',
                'meta_title_'.$this->active_local[$i]->lang => 'string|nullable',
                'meta_description_'.$this->active_local[$i]->lang => 'string|nullable',
                'meta_keywords_'.$this->active_local[$i]->lang => 'string|nullable',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        $parent_id = $request['parent_id'];
        $sorting_order = $request['sorting_order_'.$this->active_local[0]->lang];
        $last_id = Category::CreateItem($parent_id, $sorting_order);

        $i = 0;
        while ($i < count($this->active_local)) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            $lang_id = $this->active_local[$i]->id;
            $description = $request['description_'.$this->active_local[$i]->lang];
            $m_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $m_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $m_keywords = $request['meta_keywords_'.$this->active_local[$i]->lang];

            $id = DataCategory::CreateItem($last_id, $name, $lang_id, $description, $m_title, $m_description, $m_keywords);

            $i++;
        }

        return response()->json([
            'status' => 'success',
            'item_id' => $last_id,
            'url_update' => \route('category/update')
        ]);
    }

    public function Update(Request $request) {
        $validator = Validator::make(
            [
                'parent_id' => $request->parent_id,
                'item_id' => $request->item_id
            ],
            [
                'parent_id' => 'required|integer|exists:categories,id',
                'item_id' => 'required|integer|exists:categories,id'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        if ($request->parent_id == $request->item_id) {
            return response()->json([
                'error' => 'Категория не может быть сама себе родительской категорией'
            ]);
        }

        $i = 0;
        while ($i<count($this->active_local)) {
            $validator = Validator::make($request->all(), [
                'name_'.$this->active_local[$i]->lang => 'required|string',
                'sorting_order_'.$this->active_local[$i]->lang => 'required|integer',
                'description_'.$this->active_local[$i]->lang => 'string|nullable',
                'meta_title_'.$this->active_local[$i]->lang => 'string|nullable',
                'meta_description_'.$this->active_local[$i]->lang => 'string|nullable',
                'meta_keywords_'.$this->active_local[$i]->lang => 'string|nullable',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        if (Category::UpdateItem($request->item_id,
                                 $request->parent_id,
                                 $request['sorting_order_'.$this->active_local[0]->lang])) {
            $i = 0;
            while ($i < count($this->active_local)) {
                $name = $request['name_'.$this->active_local[$i]->lang];
                $lang_id = $this->active_local[$i]->id;
                $description = $request['description_'.$this->active_local[$i]->lang];
                $m_title = $request['meta_title_'.$this->active_local[$i]->lang];
                $m_description = $request['meta_description_'.$this->active_local[$i]->lang];
                $m_keywords = $request['meta_keywords_'.$this->active_local[$i]->lang];
                DataCategory::UpdateItem($request->item_id,
                    $name,
                    $lang_id,
                    $description,
                    $m_title,
                    $m_description,
                    $m_keywords);
                $i++;
            }
            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    public function Delete($id) {
        $validator = Validator::make([
            'id' => $id
        ], [
            'id' => 'required|integer|exists:categories,id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if (Category::CallDeleteItem($id)) {
            $message = 'Категория и все ее подкатегории удалены';
            return redirect()->route('admin/categories')->with('success', $message);
        }
    }
}