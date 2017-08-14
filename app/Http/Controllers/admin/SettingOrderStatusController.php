<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SettingOrderStatus;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingOrderStatusController extends Controller {
    public function Page() {
        $data = (object)[
            'title' => 'Управление статусами заказов',
            'statuses' => SettingOrderStatus::GetItems()
        ];
        return view('admin.setting_order_status.main', ['page' => $data]);
    }

    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:setting_order_statuses,name'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        $id = SettingOrderStatus::CreateItem($request->name);
        return response()->json([
            'status' => 'success',
            'item_id' => $id
        ]);
    }

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:setting_order_statuses,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $item = SettingOrderStatus::GetItem($id);
        if ($item->upon_receipt == true) {
            return redirect()->back()->with('error', 'Вы не можете удалить статус который используется при получении заказа');
        }
        SettingOrderStatus::DeleteItem($id);
        return redirect()->back()->with('success', 'Статус успешно удален');
    }

    public function ChangeUponReceipt($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:setting_order_statuses,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $item = SettingOrderStatus::GetItem($id);
        if ($item->upon_receipt) {
            return redirect()->back()->with('success', 'Этот статус уже используется как статус который используется при получении заказа');
        }
        SettingOrderStatus::ChangeUponReceipt($id);
        return redirect()->back()->with('success', 'Статус который используется при получении заказа изменен');
    }
}