<?php
namespace App\Http\Controllers\Admin;

use App\CommunicationDeliveryPayment;
use App\DataDeliveryMethod;
use App\DeliveryMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryMethod\AddOrUpdateRequest;
use App\PaymentMethod;
use App\Traits\Controllers\Admin\DeliveryMethodTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class DeliveryMethodController extends Controller {
    private $id;

    use DeliveryMethodTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Page(Request $request) {
        
        $page = 1;
        if ($request->page !== null) {
            $page = $request->page;
        }

        $data = (object)[
            'title' => 'Управление методами доставки',
            'route_name' => $this->route_name,
            'active_local' => $this->active_local,
            'delivery_methods' => $this->GetItemsFromPaginate($page),
        ];

        return view('admin.delivery_method.main', ['page' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PageAdd() {
        $data = (object)[
            'title' => 'Управление методами доставки',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'payment_methods' => $this->GetPaymentMethodsFromCache()
        ];

        return view('admin.delivery_method.work_on', ['page' => $data]);
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PageUpdate($id) {
        $this->id = $id;

        $validator = Validator::make(
            ['id' => $this->id],
            ['id' => 'required|integer|exists:delivery_methods,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //date delivery method
        if ($this->ExistItemInCache($this->id)) {
            $data_delivery_methods = $this->GetItemFromCache($this->id);
        }
        else {
            $data_delivery_methods = $this->CreateItemFromCahe($this->id);
        }

        $data = (object)[
            'title' => 'Изменение метода доставки',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'item_id' => $id,
            'data' => $this->PrepareDataLocal($data_delivery_methods),
            'payment_methods' => $this->GetPaymentMethodsFromCache(),
            'active_payment_methods' => $this->PrepareActiveData($this->GetActiveCommunicationsFromCache(), 'payment')
        ];

        return view('admin.delivery_method.work_on', ['page' => $data]);
    }

    /**
     * @param AddOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Add(AddOrUpdateRequest $request) {
        $item_id = DeliveryMethod::CreateItem();
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataDeliveryMethod::CreateItem($item_id, $this->active_local[$i]->id, $name);
            $i++;
        }
        CommunicationDeliveryPayment::CreateItems($item_id, $request->payment_methods);

        $this->ForgetItemsOfPaginate();

        return response()->json([
            'item_id' => $item_id,
            'status' => 'success'
        ]);
    }

    /**
     * @param AddOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Update(AddOrUpdateRequest $request) {
        $this->id = $request->item_id;

        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataDeliveryMethod::UpdateItem($this->id, $this->active_local[$i]->id, $name);
            $i++;
        }
        
        if ($this->ExistItemInCache($this->id)) {
            $this->ForgetItemInCache($this->id);
        }

        $this->ForgetItemsOfPaginate();

        DeliveryMethod::DeleteAllCommunications($this->id);
        CommunicationDeliveryPayment::CreateItems($this->id, $request->payment_methods);
        
        $this->ForgetCommunicationsIfExistsInCache();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function Delete($id) {
        $this->id = $id;

        $validator = Validator::make(
            ['id' => $this->id],
            ['id' => 'required|integer|exists:delivery_methods,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        
        DeliveryMethod::DeleteItem($this->id);
        
        $this->ForgetItemsOfPaginate();
        
        if ($this->ExistItemInCache($this->id)) {
            $this->ForgetItemInCache($this->id);
        }
        
        $this->ForgetCommunicationsIfExistsInCache();
        
        return redirect()->route('admin/delivery_methods')->with('success', 'Метод доставки удален');
    }
}