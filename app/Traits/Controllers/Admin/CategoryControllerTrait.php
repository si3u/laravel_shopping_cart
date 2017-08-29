<?php
namespace App\Traits\Controllers\Admin;
use App\Category;

trait CategoryControllerTrait {

    /**
     * @param $id
     * @return object
     */
    private function PrepareDataLocal($id) {
        $data_local = Category::GetDataLocalization($id);
        $prepare_data_local = null;
        foreach ($data_local as $item) {
            if ($item->lang_id == 1) {
                $prepare_data_local['ru'] = (object)[
                    'name' => $item->name,
                    'description' => $item->description,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
                    'meta_keywords' => $item->meta_keywords,
                ];
            }
            elseif ($item->lang_id == 2) {
                $prepare_data_local['ua'] = (object)[
                    'name' => $item->name,
                    'description' => $item->description,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
                    'meta_keywords' => $item->meta_keywords,
                ];
            }
            else {
                $prepare_data_local['en'] = (object)[
                    'name' => $item->name,
                    'description' => $item->description,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
                    'meta_keywords' => $item->meta_keywords,
                ];
            }
        }
        return (object)$prepare_data_local;
    }
}