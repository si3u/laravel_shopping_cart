<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Category;
use App\DefaultSize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller {
    private $active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
    }

    public function Page() {

    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление товара',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'tree' => Category::GetTree(1, 'select_multiple'),
            'size' => DefaultSize::GetItemsStatic()
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

    public function Add() {

    }

    public function Update() {

    }
}