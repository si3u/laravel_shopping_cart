<?php
namespace App\Http\Controllers\Admin;

use App\DataPaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethod\AddRequest;
use App\Http\Requests\Admin\PaymentMethod\UpdateRequest;
use App\PaymentMethod;
use App\Traits\Controllers\Admin\PaymentMethodTrait;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller {

    use PaymentMethodTrait;

    public function Page() {
        $data = (object)[
            'title' => 'Управлениями методами оплаты',
            'route_name' => $this->route_name,
            'payment_methods' => PaymentMethod::GetItems()
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
        $data = (object)[
            'title' => 'Редактирование метода оплаты',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'item_id' => $id,
            'data' => $this->PrepareDataLocal($id)
        ];
        return view('admin.payment_methods.work_on', ['page' => $data]);
    }
    public function Add(AddRequest $request) {
        $item_id = PaymentMethod::CreateItem();
        $i = 0;
        while ($i < $this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataPaymentMethod::CreateItem($item_id, $this->active_local[$i]->id, $name);
            $i++;
        }
        return response()->json([
            'status' => 'success',
            'item_id' => $item_id
        ]);
    }
    public function Update(UpdateRequest $request) {
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataPaymentMethod::UpdateItem($request->item_id, $this->active_local[$i]->id, $name);
            $i++;
        }

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
        return redirect()->route('admin/payment_methods')->with('success', 'Метод успешно удален');
    }
}