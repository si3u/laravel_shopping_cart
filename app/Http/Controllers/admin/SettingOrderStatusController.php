<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingOrderStatus\AddRequest;
use App\SettingOrderStatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\CacheTrait;

class SettingOrderStatusController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'SettingOrderStatus';
        $this->key_cache = 'setting_order_status';
    }

    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $this->tags_cache = ['setting_order_status', 'page', $page];
        $this->method_cache = 'GetItems';

        $data = (object)[
            'title' => 'Управление статусами заказов',
            'statuses' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.setting_order_status.main', ['page' => $data]);
    }

    private function ForgetItems() {
        $this->tags_cache = ['setting_order_status', 'page'];
        $this->ForgetItemsOfPaginate();
    }

    public function Add(AddRequest $request) {
        $item = SettingOrderStatus::CreateItem($request->name);

        $this->ForgetItems();

        return response()->json([
            'status' => 'success',
            'item_id' => $item
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

        $this->ForgetItems();

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

        $this->ForgetItems();

        return redirect()->back()->with('success', 'Статус который используется при получении заказа изменен');
    }
}