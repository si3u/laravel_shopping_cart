<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OrderPrintPicture;

class OrderPrintPictureController extends Controller {
    public function Page() {
        $data = (object)[
            'route_name' => $this->route_name,
            'title' => 'Заказы на печать',
            'orders' => OrderPrintPicture::GetItems()
        ];
        return view('admin.orders.print.main', ['page' => $data]);
    }
}
