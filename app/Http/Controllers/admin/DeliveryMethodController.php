<?php
namespace App\Http\Controllers\Admin;

use App\CommunicationDeliveryPayment;
use App\DataDeliveryMethod;
use App\DeliveryMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryMethod\AddOrUpdateRequest;
use App\PaymentMethod;
use App\Traits\Controllers\Admin\DeliveryMethodTrait;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class DeliveryMethodController extends Controller {
    private $id;

    use DeliveryMethodTrait;
    use CacheTrait;

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'DeliveryMethod';
        $this->key_cache = 'delivery_method';
    }

    public function Page(Request $request) {
        $page = 1;
        if ($request->page !== null) {
            $page = $request->page;
        }

        $this->method_cache = 'GetItems';
        $this->tags_cache = ['delivery_method', 'paginate', $page];

        $data = (object)[
            'title' => 'Управление методами доставки',
            'route_name' => $this->route_name,
            'active_local' => $this->active_local,
            'delivery_methods' => $this->GetOrCreateItemFromCache($page),
        ];

        return view('admin.delivery_method.main', ['page' => $data]);
    }

    public function PageAdd() {
        $this->model_cache = 'PaymentMethod';
        $this->method_cache = 'GetItemsStatic';
        $this->key_cache = 'payment_method';

        $data = (object)[
            'title' => 'Управление методами доставки',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'payment_methods' => $this->GetOrCreateItemFromCache()
        ];

        return view('admin.delivery_method.work_on', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $this->id = $id;

        $validator = Validator::make(
            ['id' => $this->id],
            ['id' => 'required|integer|exists:delivery_methods,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->tags_cache = ['delivery_method', 'item', $this->id];
        $this->method_cache = 'GetDataLocalization';
        $this->parameters_cache = [$this->id];
        $data_delivery = $this->GetOrCreateItemFromCache();

        $this->tags_cache = null;
        $this->key_cache = 'payment_method';
        $this->model_cache = 'PaymentMethod';
        $this->method_cache = 'GetItemsStatic';
        $data_payment = $this->GetOrCreateItemFromCache();

        $this->tags_cache = ['communications_delivery_method', $this->id];
        $this->key_cache = 'communications_delivery_method';
        $this->model_cache = 'DeliveryMethod';
        $this->method_cache = 'ActiveCommunications';
        $data_communication = $this->GetOrCreateItemFromCache();

        $data = (object)[
            'title' => 'Изменение метода доставки',
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'item_id' => $id,
            'data' => $this->PrepareDataLocal($data_delivery),
            'payment_methods' => $data_payment,
            'active_payment_methods' => $this->PrepareActiveData($data_communication, 'payment')
        ];

        return view('admin.delivery_method.work_on', ['page' => $data]);
    }

    public function Add(AddOrUpdateRequest $request) {
        $item_id = DeliveryMethod::CreateItem();
        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataDeliveryMethod::CreateItem($item_id, $this->active_local[$i]->id, $name);
            $i++;
        }
        CommunicationDeliveryPayment::CreateItems($item_id, $request->payment_methods);

        $this->tags_cache = ['delivery_method', 'paginate'];
        $this->ForgetItemsOfPaginate();

        return response()->json([
            'item_id' => $item_id,
            'status' => 'success'
        ]);
    }

    public function Update(AddOrUpdateRequest $request) {
        $this->id = $request->item_id;

        $i = 0;
        while ($i<$this->count_active_local) {
            $name = $request['name_'.$this->active_local[$i]->lang];
            DataDeliveryMethod::UpdateItem($this->id, $this->active_local[$i]->id, $name);
            $i++;
        }

        $this->tags_cache = ['delivery_method', 'item', $this->id];
        $this->ForgetItemInCache();

        $this->tags_cache = ['delivery_method', 'paginate'];
        $this->ForgetItemsOfPaginate();

        DeliveryMethod::DeleteAllCommunications($this->id);
        CommunicationDeliveryPayment::CreateItems($this->id, $request->payment_methods);
        
        $this->tags_cache = ['communications_delivery_method', $this->id];
        $this->key_cache = 'communications_delivery_method';
        $this->ForgetItemInCache();

        return response()->json([
            'status' => 'success'
        ]);
    }

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
        
        $this->tags_cache = ['delivery_method', 'paginate'];
        $this->ForgetItemsOfPaginate();

        $this->tags_cache = ['delivery_method', 'item', $this->id];
        $this->ForgetItemInCache();
        
        $this->tags_cache = ['communications_delivery_method', $this->id];
        $this->key_cache = 'communications_delivery_method';
        $this->ForgetItemInCache();
        
        return redirect()->route('admin/delivery_methods')->with('success', 'Метод доставки удален');
    }
}