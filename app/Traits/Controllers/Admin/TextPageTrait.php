<?php
namespace App\Traits\Controllers\Admin;

use App\TextPage;

trait TextPageTrait {

    /**
     * @param $id
     * @return object
     */
    private function PrepareData($data) {
        $prepare_data = null;
        foreach ($data as $datum) {
            if ($datum->lang_id == 1) {
                $prepare_data['ru'] = (object)[
                    'value' => $datum->value
                ];
            }
            elseif ($datum->lang_id == 2) {
                $prepare_data['ua'] = (object)[
                    'value' => $datum->value
                ];
            }
            else {
                $prepare_data['en'] = (object)[
                    'value' => $datum->value
                ];
            }
        }
        return (object)$prepare_data;
    }
}