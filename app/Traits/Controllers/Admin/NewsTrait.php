<?php
namespace App\Traits\Controllers\Admin;

use App\News;

trait NewsTrait {

    /**
     * @param $id
     * @return object
     */
    private function PrepareDataLocal($id) {
        $data_local = News::GetItemAndLocalData($id, $this->active_local_id);
        $prepare_data_local = null;
        foreach ($data_local as $item) {
            $key = '';
            switch ($item->lang_id) {
                case 1:
                    $key = 'ru';
                    break;
                case 2:
                    $key = 'ua';
                    break;
                case 3:
                    $key = 'en';
                    break;
            }
            $prepare_data_local[$key] = (object)[
                'topic' => $item->topic,
                'text' => $item->text,
                'meta_title' => $item->meta_title,
                'meta_description' => $item->meta_description,
                'meta_keywords' => $item->meta_keywords,
                'tags' => $item->tags,
            ];
        }
        return (object)$prepare_data_local;
    }
}