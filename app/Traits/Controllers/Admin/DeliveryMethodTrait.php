<?php
namespace App\Traits\Controllers\Admin;

use App\DeliveryMethod;
use Illuminate\Support\Facades\Cache;

trait DeliveryMethodTrait {

    /**
     * @param $data_local
     * @return object
     */
    private function PrepareDataLocal($data_local) {
        $prepare_data_local = null;
        foreach ($data_local as $item) {
            if ($item->lang_id == 1) {
                $prepare_data_local['ru'] = (object)[
                    'name' => $item->name
                ];
            }
            elseif ($item->lang_id == 2) {
                $prepare_data_local['ua'] = (object)[
                    'name' => $item->name
                ];
            }
            else {
                $prepare_data_local['en'] = (object)[
                    'name' => $item->name
                ];
            }
        }
        return (object)$prepare_data_local;
    }

    private function PrepareActiveData($data, $option) {
        $i = 0;
        $count = count($data);
        $result = [];
        while ($i < $count) {
            switch ($option) {
                case 'payment':
                    $result[] = $data[$i]->payment_id;
                    break;
            }
            $i++;
        }
        return $result;
    }

    private function GetPaymentMethodsFromCache() {
        return Cache::rememberForever('payment_method', function() {
            return PaymentMethod::GetItemsStatic();
        });
    }

    public function ExistItemInCache($id) {
        return Cache::tags(['delivery_method', 'item', $id])->has('delivery_method');
    }

    public function GetItemFromCache($id) {
        return Cache::tags(['delivery_method', 'item', $id])->get('delivery_method');
    }

    public function CreateItemFromCahe() {
        return Cache::tags(['delivery_method', 'item', $this->id])->rememberForever('delivery_method', function () {
            return DeliveryMethod::GetDataLocalization($this->id);
        });
    }

    public function ForgetItemInCache($id) {
        Cache::tags(['delivery_method', 'item', $id])->forget('delivery_method');
    }

    public function GetItemsFromPaginate($page) {
        return Cache::tags(['delivery_method', 'paginate', $page])->rememberForever('delivery_method', function() {
            return DeliveryMethod::GetItems();
        });
    }
    
    public function ForgetItemsOfPaginate() {
        Cache::tags(['delivery_method', 'paginate'])->flush();
    }

    private function ForgetCommunicationsIfExistsInCache() {
        if (Cache::tags(['communications_delivery_method', $this->id])->has('communications_delivery_method')) {
            Cache::tags(['communications_delivery_method', $this->id])->flush('communications_delivery_method');
        }
    }

    private function GetActiveCommunicationsFromCache() {
        return Cache::tags(['communications_delivery_method', $this->id])->get('communications_delivery_method', function() {
            return DeliveryMethod::ActiveCommunications($this->id);
        });
    }
}