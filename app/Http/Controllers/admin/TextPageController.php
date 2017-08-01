<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Http\Controllers\Controller;
use App\TextPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class TextPageController extends Controller {
    private $active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
    }

    public function Get($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:text_pages,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        $data = (object)[
            'title' => 'Текстовая страница',
            'item' => TextPage::GetItem($id)
        ];
        return view('admin.text_page.work_on', ['page' => $data]);
    }

    public function Update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:text_pages,id',
            'value' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        if (TextPage::UpdateItem($request->id, $request->value)) {
            return response()->json(['status' => 'success']);
        }
    }
}