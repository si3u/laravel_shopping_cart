<?php
namespace App\Http\Controllers\Admin;

use App\CommunicationDeliveryPayment;
use App\DataDeliveryMethod;
use App\DeliveryMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryMethod\AddRequest;
use App\Http\Requests\Admin\DeliveryMethod\UpdateRequest;
use App\PaymentMethod;
use App\Traits\Controllers\Admin\DeliveryMethodTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryMethodController extends Controller {

    use DeliveryMethodTrait;

    public function Page() {
        $data = (object)[
            'title' => 'Управление методами доставки',
            'route_name' => $this->route_name,
            'active_local' => $this->active_local,
            'delivery_methods' => DeliveryMethod::GetItems(),
        ];

        return view('admin.delivery_method.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Управление методами доставки',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'payment_methods' => PaymentMethod::GetItemsStatic()
        ];

        return view('admin.delivery_method.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:delivery_methods,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = (object)[
            'title' => 'Изменение метода доставки',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'item_id' => $id,
            'data' => $this->PrepareDataLocal(DeliveryMethod::GetDataLocalization($id)),
            'payment_methods' => PaymentMethod::GetItemsStatic(),
            'active_payment_methods' => $this->PrepareActiveData(DeliveryMethod::ActiveCommunications($id), 'payment')
        ];

        return view('admin.delivery_method.work_on', ['page' => $data]);
    }

    public function Add(AddRequest $request) {
        $item_id = DeliveryMethod::CreateItem();
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataDeliveryMethod::CreateItem($item_id, $this->active_local[$i]->id, $name);
            $i++;
        }
        CommunicationDeliveryPayment::CreateItems($item_id, $request->payment_methods);
        return response()->json([
            'item_id' => $item_id,
            'status' => 'success'
        ]);
    }

    public function Update(UpdateRequest $request) {
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataDeliveryMethod::UpdateItem($request->item_id, $this->active_local[$i]->id, $name);
            $i++;
        }
        DeliveryMethod::DeleteAllCommunications($request->item_id);
        CommunicationDeliveryPayment::CreateItems($request->item_id, $request->payment_methods);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:delivery_methods,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        DeliveryMethod::DeleteItem($id);
        return redirect()->route('admin/delivery_methods')->with('success', 'Метод доставки удален');
    }
}