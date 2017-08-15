<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
