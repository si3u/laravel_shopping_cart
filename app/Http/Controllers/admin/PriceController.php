<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller {

    public function Page() {
        $data = (object)[
            'title' => 'Настройка цен',
            'data' => Price::GetData()
        ];
        return view('admin.price.work_on', ['page' => $data]);
    }

    public function Update(Request $request) {
        $validator = Validator::make(Input::all(), [
           'natural_canvas' => 'required|between:0,99999999.99',
           'artificial_canvas' => 'required|between:0,99999999.99',
           'running_meter' => 'required|between:0,99999999.99',
           'for_work' => 'required|between:0,99999999.99',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (Price::UpdateItem($request->natural_canvas,
                              $request->artificial_canvas,
                              $request->running_meter,
                              $request->for_work)) {
            return redirect()->back()->with('success', 'Цены успешно обновлены')->withInput();
        }
    }
}