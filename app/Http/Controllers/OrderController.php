<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Price;
use App\Traits\OrderControllerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private $prices;
    private $full_price;
    private $date;
    private $order_items;

    public function __construct() {
        parent::__construct();
        $this->prices = Price::GetData();
        $this->date = Carbon::now()->toDateString();
    }

    use OrderControllerTrait;

    public function Create(Request $request) {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|max:255',
            'tel' => 'required|string|max:255',
            'address' => 'required|string',
            'delivery_method' => 'required|integer|exists:delivery_methods,id',
            'payment_method' => 'required|integer|exists:payment_methods,id',

            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.type' => 'required|integer|between:0,1',
            'items.*.canvas' => 'required|integer|between:0,1',
            'items.*.width' => 'required|integer',
            'items.*.height' => 'required|integer',
            'items.*.modular_id' => 'integer|exists:modular_images,id',

            'items.*.crop.*.width' => 'integer',
            'items.*.crop.*.height' => 'integer',
            'items.*.crop.*.top' => 'integer',
            'items.*.crop.*.left' => 'integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        $path = public_path('assets/images/orders/' . $this->date);
        File::makeDirectory($path, $mode = 0777, true, true);

        $order_id = Order::CreateItem($request->full_name, $request->email, $request->tel, $request->address,
                                      $request->delivery_method, $request->payment_method);

        $this->CreateOrderItems($order_id, $request->items);

        $this->full_price += $this->prices->for_work;
        Order::UpdateFullPrice($order_id, $this->full_price);
        OrderItem::CreateItems($this->order_items);
        return response()->json([
            'status' => 'success'
        ]);
    }

}
