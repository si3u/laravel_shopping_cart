<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Category;
use App\DefaultSize;
use App\FilterByColor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller {
    private $active_local;
    private $active_local_id;
    private $count_active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
        $this->count_active_local = count($this->active_local);
        $i = 0;
        while ($i < $this->count_active_local) {
            $this->active_local_id[] = $this->active_local[$i]->id;
            $i++;
        }
    }

    public function Page() {
        $data = (object)[
            'title' => 'Управление товарами',
        ];
        return view('admin.product.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'tree' => Category::GetTree(1, 'select_multiple'),
            'size' => DefaultSize::GetItemsStatic(),
            'color' => FilterByColor::GetItemsStatic()
        ];
        return view('admin.product.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:products,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = (object)[
            'title' => 'Добавление товара',
            'active_local' => $this->active_local,
            'route_name' => $this->route_name,
            'item' => ''
        ];
        return view('admin.product.work_on', ['page' => $data]);
    }

    public function Add(Request $request) {
        $i = 0;
        while ($i<$this->count_active_local) {
            $validator = Validator::make($request->all(), [
                    'name_'.$this->active_local[$i]->lang => 'required|string|min:1|max:255',
                    'meta_title_'.$this->active_local[$i]->lang => 'string|max:255|nullable',
                    'meta_description_'.$this->active_local[$i]->lang => 'string|nullable',
                    'meta_keywords_'.$this->active_local[$i]->lang => 'string|nullable',
                    'tags_'.$this->active_local[$i]->lang => 'string|nullable'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'min_width' => 'required|integer',
            'max_width' => 'required|integer',
            'min_height' => 'required|integer',
            'max_height' => 'required|integer',
            'category' => 'required',
            'category.*' => 'required|integer|exists:categories,id',
            'size' => 'required',
            'size.*' => 'required|integer|exists:default_sizes,id',
            'color.*' => 'nullable|integer|exists:filter_by_colors,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }



        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Update() {

    }
}