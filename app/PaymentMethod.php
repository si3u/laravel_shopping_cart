<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PaymentMethod extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function DataLocal() {
        return $this->hasOne('App\DataPaymentMethod', 'payment_method_id');
    }
    public function DataLocals() {
        return $this->hasMany('App\DataPaymentMethod', 'payment_method_id');
    }

    protected function GetItems() {
        $query = PaymentMethod::query();
        $query->with(['DataLocal' => function($q) {
            $q->where('lang_id', 1);
        }]);
        return $query->orderBy('id', 'desc')->paginate(10);
    }

    public static function GetItemsStatic() {
        $query = PaymentMethod::query();
        $query->with(['DataLocal' => function($q) {
            $q->where('lang_id', 1);
        }]);
        return $query->orderBy('id', 'desc')->get();
    }

    protected function CreateItem() {
        return PaymentMethod::insertGetId([]);
    }

    protected function GetDataLocalization($id) {
        return PaymentMethod::find($id)->DataLocals()->get();
    }

    protected function DeleteItem($id) {
        PaymentMethod::find($id)->DataLocals()->delete();
        PaymentMethod::find($id)->delete();
    }
}
