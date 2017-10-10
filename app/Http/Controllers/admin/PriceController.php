<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Price\UpdateRequest;
use App\Price;
use App\Traits\CacheTrait;

class PriceController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'Price';
        $this->method_cache = 'GetData';
        $this->key_cache = 'price';
    }

    use CacheTrait;

    public function Page() {
        $data = (object)[
            'title' => 'Настройка цен',
            'data' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.price.work_on', ['page' => $data]);
    }

    public function Update(UpdateRequest $request) {
        if (Price::UpdateItem($request->natural_canvas,
                              $request->artificial_canvas,
                              $request->running_meter,
                              $request->for_work)) {

            $this->ForgetItemInCache();

            return redirect()->back()->with('success', 'Цены успешно обновлены')->withInput();
        }
    }
}