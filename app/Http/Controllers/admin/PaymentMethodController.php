<?php
namespace App\Http\Controllers\Admin;

use App\DataPaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethod\AddOrUpdateRequest;
use App\PaymentMethod;
use App\Traits\Controllers\Admin\PaymentMethodTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\CacheTrait;

class PaymentMethodController extends Controller {
    public function __construct() {
        parent::__construct();

        $this->model_cache = 'PaymentMethod';
        $this->key_cache = 'payment_method';
    }

    use PaymentMethodTrait;
    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request)) {
            $page = $request->page;
        }

        $this->tags_cache = ['payment_method', 'page', $page];
        $this->method_cache = 'GetItems';

        $data = (object)[
            'title' => 'Управлениями методами оплаты',
            'route_name' => $this->route_name,
            'payment_methods' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.payment_methods.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление метода оплаты',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local
        ];
        return view('admin.payment_methods.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:payment_methods,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->method_cache = 'GetDataLocalization';
        $this->tags_cache = ['payment_method', 'item', $id];
        $this->parameters_cache = [$id];

        $data = (object)[
            'title' => 'Редактирование метода оплаты',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'item_id' => $id,
            'data' => $this->PrepareDataLocal($this->GetOrCreateItemFromCache())
        ];
        return view('admin.payment_methods.work_on', ['page' => $data]);
    }

    public function Add(AddOrUpdateRequest $request) {
        $item_id = PaymentMethod::CreateItem();
        $i = 0;
        while ($i < $this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataPaymentMethod::CreateItem($item_id, $this->active_local[$i]->id, $name);
            $i++;
        }

        $this->tags_cache = ['payment_method', 'page'];
        $this->ForgetItemsOfPaginate();

        return response()->json([
            'status' => 'success',
            'item_id' => $item_id
        ]);
    }

    public function Update(AddOrUpdateRequest $request) {
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataPaymentMethod::UpdateItem($request->item_id, $this->active_local[$i]->id, $name);
            $i++;
        }

        $this->tags_cache = ['payment_method', 'item', $request->item_id];
        $this->ForgetItemInCache();
        $this->tags_cache = ['payment_method', 'page'];
        $this->ForgetItemsOfPaginate();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:payment_methods,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        PaymentMethod::DeleteItem($id);
        
        $this->tags_cache = ['payment_method', 'item', $id];
        $this->ForgetItemInCache();
        $this->tags_cache = ['payment_method', 'page'];
        $this->ForgetItemsOfPaginate();

        return redirect()->route('admin/payment_methods')->with('success', 'Метод успешно удален');
    }
}