<?php
namespace App\Traits\Controllers\Admin;

trait ContactTrait {
    function PreperaData($data) {
        $prepare_data = null;
        foreach ($data as $item) {
            if ($item->lang_id == 1) {
                $prepare_data['ru'] = (object)[
                    'addresses' => $item->addresses,
                    'working_days' => $item->working_days
                ];
            }
            elseif ($item->lang_id == 2) {
                $prepare_data['ua'] = (object)[
                    'addresses' => $item->addresses,
                    'working_days' => $item->working_days
                ];
            }
            else {
                $prepare_data['en'] = (object)[
                    'addresses' => $item->addresses,
                    'working_days' => $item->working_days
                ];
            }
        }
        return (object)$prepare_data;
    }
}
