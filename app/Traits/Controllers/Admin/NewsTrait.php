<?php
namespace App\Traits\Controllers\Admin;

use App\News;
use Illuminate\Support\Facades\Cache;

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

    public function ExistItemInCache() {
        return Cache::tags(['news', 'item', $this->item_id])->has('news');
    }

    public function GetItemFromCache() {
        return Cache::tags(['news', 'item', $this->item_id])->get('news');
    }

    public function CreateItemFromCahe() {
        return Cache::tags(['news', 'item', $this->item_id])->rememberForever('news', function () {
            return News::GetItem($this->item_id);
        });
    }

    public function ForgetItemInCache() {
        Cache::tags(['news', 'item', $this->item_id])->forget('news');
    }

    public function GetItemsFromPaginate($page) {
        return Cache::tags(['news', 'paginate', $page])->rememberForever('news', function() {
            return News::GetItems();
        });
    }
    
    public function ForgetItemsOfPaginate() {
        Cache::tags(['news', 'paginate'])->flush();
    }
}