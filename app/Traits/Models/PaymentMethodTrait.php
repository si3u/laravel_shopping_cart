<?php
namespace App\Traits\Models;

trait PaymentMethodTrait {
    /**
     * @return mixed
     */
    public function DataLocal() {
        return $this->hasOne('App\DataPaymentMethod', 'payment_method_id');
    }

    /**
     * @return mixed
     */
    public function DataLocals() {
        return $this->hasMany('App\DataPaymentMethod', 'payment_method_id');
    }
}