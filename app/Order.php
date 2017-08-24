<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $tel
 * @property string $address
 * @property int $delivery_method
 * @property int $payment_method
 * @property float $full_price
 * @property int $read_status
 * @property int|null $order_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeliveryMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereReadStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereFullPrice($value)
 */
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
