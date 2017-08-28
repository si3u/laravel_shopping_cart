<?php
namespace App\Traits\Models;

trait PaymentMethodTrait {
    public function DataLocal() {
        return $this->hasOne('App\DataPaymentMethod', 'payment_method_id');
    }
    public function DataLocals() {
        return $this->hasMany('App\DataPaymentMethod', 'payment_method_id');
    }
}