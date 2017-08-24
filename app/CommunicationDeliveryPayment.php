<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CommunicationDeliveryPayment
 *
 * @property int $delivery_id
 * @property int $payment_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunicationDeliveryPayment whereDeliveryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunicationDeliveryPayment wherePaymentId($value)
 * @mixin \Eloquent
 */
class CommunicationDeliveryPayment extends Model
{
    public $timestamps = false;

    public static function CreateItems($delivery_id, $payment_ids) {
        $data = [];
        $i = 0;
        $count = count($payment_ids);
        while ($i<$count) {
            $data[] = [
                'delivery_id' => $delivery_id,
                'payment_id' => $payment_ids[$i]
            ];
            $i++;
        }
        CommunicationDeliveryPayment::insert($data);
    }
}
