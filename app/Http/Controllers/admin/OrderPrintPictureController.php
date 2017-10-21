<?php

namespace App\Http\Controllers\Admin;

use App\SettingOrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OrderPrintPicture;
use App\Http\Requests\OrderPrintPicture\UpdateRequest;

class OrderPrintPictureController extends Controller {
    public function Page() {
        $data = (object)[
            'route_name' => $this->route_name,
            'title' => 'Заказы на печать',
            'orders' => OrderPrintPicture::GetItems()
        ];
        return view('admin.orders.print.main', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:order_print_pictures,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $order = OrderPrintPicture::GetItem($id);
        if ($order->read_status == false) {
            $order->read_status = true;
            $order->save();
        }
        $processing_statuses = SettingOrderStatus::GetItemsStatic();

        $data = (object)[
            'route_name' => $this->route_name,
            'title' => 'Изменение заказа на печать',
            'order' => $order,
            'processing_statuses' => $processing_statuses
        ];
        return view('admin.orders.print.work_on', ['page' => $data]);
    }

    public function Update(UpdateRequest $request) {
        OrderPrintPicture::UpdateItem(
            $request->id,
            $request->tel,
            $request->width,
            $request->height,
            $request->canvas,
            $request->processing_status
        );

        return response()->json(['status' => 'success']);
    }

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:order_print_pictures,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        OrderPrintPicture::DeleteItem($id);

        return redirect()->route('admin/orders/print_pictures')->with(
            'success', 'Заказ был успешно удалена'
        );
    }
}
