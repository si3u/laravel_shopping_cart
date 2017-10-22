<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class WallpaperCategory extends Model
{
    use NestableTrait;
    protected $primaryKey = 'id';
    protected $parent = 'parent_id';
    public $timestamps = false;
    private $array_id;

    public function DataLocalization() {
        return $this->hasMany('App\DataWallpaperCategory', 'category_id');
    }

    protected function GetItem($id) {
        return WallpaperCategory::find($id);
    }

    public static function GetTree($select, $output, $include_root = true) {
        $query = WallpaperCategory::query();
        $query->join('data_wallpaper_categories', 'wallpaper_categories.id', '=', 'data_wallpaper_categories.category_id');
        if (!$include_root) {
            $query->where('wallpaper_categories.id', '<>', 1);
        }
        $query->where('data_wallpaper_categories.lang_id', 1)
        ->orderBy('wallpaper_categories.sorting_order', 'asc')
        ->select(
            'wallpaper_categories.id',
            'wallpaper_categories.parent_id',
            'data_wallpaper_categories.name',
            'wallpaper_categories.slug'
        );
        $data = $query->get();
        $prepare_data = array();
        $i = 0;
        while ($i < count($data)) {
            array_push($prepare_data, [
                'id' => $data[$i]->id,
                'parent_id' => $data[$i]->parent_id,
                'name' => $data[$i]->name,
                'slug' => $data[$i]->slug
            ]);
            $i++;
        }
        $result = \Nestable::make($prepare_data);
        switch ($output) {
            case 'add_or_update':
                return $result->attr([
                    'class' => 'form-control',
                    'name' => 'parent_id',
                    'id' => 'parent_id'
                ])->selected($select)->renderAsDropdown();
                break;
            case 'categories/main':
                return $result->ulAttr(['class' => 'sitemap'])
                    ->route(['wallpaper_categories/update' => 'id'])
                    ->renderAsHtml();
                break;
            case 'json':
                return $result->attr([
                    'class' => 'form-control',
                    'name' => 'parent_id',
                    'id' => 'parent_id'
                ])->selected($select)->renderAsJson();
                break;
            case 'select_multiple':
                return $result->attr([
                    'class' => 'form-control',
                    'name' => 'category[]',
                    'id' => 'category'
                ])->selected($select)->renderAsMultiple();
                break;
        }
    }

    protected function CreateItem($parent_id, $sorting_order)
    {
        $data_insert = [
            'sorting_order' => $sorting_order
        ];
        if ($parent_id == 1) {
            $data_insert += ['parent_id' => 0];
        } else {
            $data_insert += ['parent_id' => $parent_id];
        }
        return WallpaperCategory::insertGetId($data_insert);
    }

    protected function GetDataItem($id) {
        return WallpaperCategory::find($id);
    }
    protected function GetDataLocalization($id) {
        return WallpaperCategory::find($id)->DataLocalization;
    }

    protected function UpdateItem($id, $parent_id, $sorting_order) {
        $item = WallpaperCategory::find($id);
        if ($parent_id == 1) {
            $item->parent_id = 0;
        }
        else {
            $item->parent_id = $parent_id;
        }
        $item->sorting_order = $sorting_order;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    private function DeleteItems() {
        WallpaperCategory::whereIn('id', $this->array_id)->delete();
        DataWallpaperCategory::DeleteItems($this->array_id);
    }

    private function SearchId($data) {
        $count = count($data);
        $i = 0;
        while ($i < $count) {
            $this->array_id[] = $data[$i]['id'];
            if (count($data[$i]['child']) > 0) {
                $this->SearchId($data[$i]['child']);
            }
            $i++;
        }
    }
    protected function CallDeleteItem($id) {
        $this->array_id[] = $id;
        $this->SearchId(WallpaperCategory::parent($id)->renderAsArray());
        $this->DeleteItems();
        return true;
    }
}
