<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingOrderStatus\AddRequest;
use App\SettingOrderStatus;
use Illuminate\Support\Facades\Validator;

class SettingOrderStatusController extends Controller {

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Page() {
        $data = (object)[
            'title' => 'Управление статусами заказов',
            'statuses' => SettingOrderStatus::GetItems()
        ];
        return view('admin.setting_order_status.main', ['page' => $data]);
    }

    /**
     * @param AddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Add(AddRequest $request) {
        return response()->json([
            'status' => 'success',
            'item_id' => SettingOrderStatus::CreateItem($request->name)
        ]);
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
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