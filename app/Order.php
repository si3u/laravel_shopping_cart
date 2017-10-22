<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $primaryKey = 'id';

    protected function CreateItem($full_name, $email, $tel, $address, $delivery, $payment) {
        $datetime = Carbon::now()->toDateTimeString();
        $data = [
            'full_name' => $full_name,
            'email' => $email,
            'tel' => $tel,
            'address' => $address,
            'delivery_method' => $delivery,
            'payment_method' => $payment,
            'read_status' => false,
            'order_status' => SettingOrderStatus::GetActive(),
            'created_at' => $datetime,
            'updated_at' => $datetime
        ];
        return Order::insertGetId($data);
    }

    protected function UpdateFullPrice($id, $full_price) {
        $item = Order::find($id);
        $item->full_price = $full_price;
        $item->save();
    }
}
