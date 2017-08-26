<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Price\UpdateRequest;
use App\Price;

class PriceController extends Controller {

    public function Page() {
        $data = (object)[
            'title' => 'Настройка цен',
            'data' => Price::GetData()
        ];
        return view('admin.price.work_on', ['page' => $data]);
    }

    public function Update(UpdateRequest $request) {
        if (Price::UpdateItem($request->natural_canvas,
                              $request->artificial_canvas,
                              $request->running_meter,
                              $request->for_work)) {
            return redirect()->back()->with('success', 'Цены успешно обновлены')->withInput();
        }
    }
}