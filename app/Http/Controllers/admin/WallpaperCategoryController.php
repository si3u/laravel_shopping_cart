<?php

namespace App\Http\Controllers\Admin;

use App\WallpaperCategory;
use App\DataWallpaperCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WallpaperCategory\AddOrUpdateRequest;
use App\Traits\Controllers\Admin\WallpaperCategoryControllerTrait;
use Illuminate\Support\Facades\Validator;

class WallpaperCategoryController extends Controller {

    use WallpaperCategoryControllerTrait;

    public function Page() {
        $data = (object)[
            'title' => 'Древо категорий',
            'tree' => WallpaperCategory::GetTree(null, 'categories/main', false)
        ];
        return view('admin.items.wallpaper.categories.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = [
            'title' => 'Добавить категорию',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'parents' => WallpaperCategory::GetTree(null, 'add_or_update')
        ];
        return view('admin.items.wallpaper.categories.work_on', ['page' => (object)$data]);
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
            ['id' => 'required|integer|exists:wallpaper_categories,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $category = WallpaperCategory::GetDataItem($id);
        $data = (object)[
            'title' => 'Изменение категории',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'parents' => WallpaperCategory::GetTree($category->parent_id, 'add_or_update'),
            'category' => $category,
            'data_local' => $this->PrepareDataLocal($id)
        ];

        return view('admin.items.wallpaper.categories.work_on', ['page' => $data]);
    }

    public function Add(AddOrUpdateRequest $request) {
        $parent_id = $request['parent_id'];
        $sorting_order = $request['sorting_order_'.$this->active_local[0]->lang];
        $last_id = WallpaperCategory::CreateItem($parent_id, $sorting_order);

        $i = 0;
        while ($i < count($this->active_local)) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            $lang_id = $this->active_local[$i]->id;
            $description = $request['description_'.$this->active_local[$i]->lang];
            $m_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $m_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $m_keywords = $request['meta_keywords_'.$this->active_local[$i]->lang];

            DataWallpaperCategory::CreateItem($last_id, $name, $lang_id, $description, $m_title, $m_description, $m_keywords);
            $i++;
        }

        return response()->json([
            'status' => 'success',
            'item_id' => $last_id,
            'url_update' => \route('wallpaper_category/update')
        ]);
    }

    public function Update(AddOrUpdateRequest $request) {
        if ($request->parent_id == $request->item_id) {
            return response()->json([
                'error' => 'Категория не может быть сама себе родительской категорией'
            ]);
        }

        if (WallpaperCategory::UpdateItem($request->item_id, $request->parent_id, $request['sorting_order_'.$this->active_local[0]->lang])) {
            $i = 0;
            while ($i < count($this->active_local)) {
                $name = $request['name_'.$this->active_local[$i]->lang];
                $lang_id = $this->active_local[$i]->id;
                $description = $request['description_'.$this->active_local[$i]->lang];
                $m_title = $request['meta_title_'.$this->active_local[$i]->lang];
                $m_description = $request['meta_description_'.$this->active_local[$i]->lang];
                $m_keywords = $request['meta_keywords_'.$this->active_local[$i]->lang];
                DataWallpaperCategory::UpdateItem($request->item_id,
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
            'id' => 'required|integer|exists:wallpaper_categories,id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if (WallpaperCategory::CallDeleteItem($id)) {
            $message = 'Категория и все ее подкатегории удалены';
            return redirect()->route('admin/wallpaper_categories')->with('success', $message);
        }
    }
}
