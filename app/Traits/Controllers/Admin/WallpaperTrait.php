<?php
namespace App\Traits\Controllers\Admin;

trait WallpaperTrait {
    private function PrepareActiveData($data, $option) {
        $i = 0;
        $count = count($data);
        $result = [];
        while ($i < $count) {
            switch ($option) {
                case 'category':
                    $result[] = $data[$i]->category_id;
                    break;
                case 'color':
                    $result[] = $data[$i]->color_id;
                    break;
                case 'size':
                    $result[] = $data[$i]->size_id;
                    break;
            }
            $i++;
        }
        return $result;
    }

    private function PrepareDataLocal($data_local) {
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
                'name' => $item->name,
                'meta_title' => $item->meta_title,
                'meta_description' => $item->meta_description,
                'meta_keywords' => $item->meta_keywords,
                'tags' => $item->tags,
            ];
        }
        return (object)$prepare_data_local;
    }
}
