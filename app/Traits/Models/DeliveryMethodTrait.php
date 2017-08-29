<?php
namespace App\Traits\Models;

trait DeliveryMethodTrait {
    /**
     * @return mixed
     */
    public function CommunicationWithPayment() {
        return $this->hasMany('App\CommunicationDeliveryPayment', 'delivery_id');
    }

    /**
     * @return mixed
     */
    public function DataLocal() {
        return $this->hasOne('App\DataDeliveryMethod', 'delivery_method_id');
    }

    /**
     * @return mixed
     */
    public function DataLocals() {
        return $this->hasMany('App\DataDeliveryMethod', 'delivery_method_id');
    }
}