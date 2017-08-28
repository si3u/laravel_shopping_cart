<?php
namespace App\Traits\Models;

trait DeliveryMethodTrait {
    public function CommunicationWithPayment() {
        return $this->hasMany('App\CommunicationDeliveryPayment', 'delivery_id');
    }
    public function DataLocal() {
        return $this->hasOne('App\DataDeliveryMethod', 'delivery_method_id');
    }
    public function DataLocals() {
        return $this->hasMany('App\DataDeliveryMethod', 'delivery_method_id');
    }
}