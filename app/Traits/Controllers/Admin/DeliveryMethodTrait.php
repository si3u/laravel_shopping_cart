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
}