<?php

namespace App;

use App\Traits\Models\DeliveryMethodTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\DeliveryMethod
 *
 * @property int $id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CommunicationDeliveryPayment[] $CommunicationWithPayment
 * @property-read \App\DataDeliveryMethod $DataLocal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataDeliveryMethod[] $DataLocals
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryMethod whereId($value)
 * @mixin \Eloquent
 */
class DeliveryMethod extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';

    use DeliveryMethodTrait;

    protected function CreateItem() {
        return DeliveryMethod::insertGetId([]);
    }

    protected function GetItems() {
        $query = DeliveryMethod::query();
        $query->with(['DataLocal' => function($q) {
            $q->where('lang_id', 1);
        }]);
        return $query->orderBy('id', 'desc')->paginate(10);
    }

    protected function GetDataLocalization($id) {
        return DeliveryMethod::find($id)->DataLocals()->get();
    }

    protected function DeleteAllCommunications($id) {
        DeliveryMethod::find($id)->CommunicationWithPayment()->delete();
    }

    protected function ActiveCommunications($id) {
        return DeliveryMethod::find($id)
            ->CommunicationWithPayment()
            ->select('payment_id')
            ->get();
    }

    protected function DeleteItem($id) {
        DeliveryMethod::find($id)->CommunicationWithPayment()->delete();
        DeliveryMethod::find($id)->delete();
    }
}
