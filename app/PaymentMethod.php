<?php

namespace App;

use App\Traits\Models\PaymentMethodTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\PaymentMethod
 *
 * @property int $id
 * @property-read \App\DataPaymentMethod $DataLocal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataPaymentMethod[] $DataLocals
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentMethod whereId($value)
 * @mixin \Eloquent
 */
class PaymentMethod extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';

    use PaymentMethodTrait;

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
