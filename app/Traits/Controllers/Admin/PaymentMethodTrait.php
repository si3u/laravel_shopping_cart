<?php
namespace App\Traits\Controllers\Admin;

use App\PaymentMethod;

trait PaymentMethodTrait {
    private function PrepareDataLocal($id) {
        $data_local = PaymentMethod::GetDataLocalization($id);
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
}