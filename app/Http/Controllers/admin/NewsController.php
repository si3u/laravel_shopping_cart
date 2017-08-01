<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class NewsController extends Controller {
    private $active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
    }

    public function Page($id) {
        $data = (object)[
            'title' => 'Новости',
            'item' => TextPage::GetItem($id)
        ];
        return view('admin.text_page.work_on', ['page' => $data]);
    }
}