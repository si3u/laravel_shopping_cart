<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Nestable\NestableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $sorting_order
 * @property int|null $parent_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereSortingOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereSlug($value)
 * @property int $lang_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereLangId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataCategory[] $DataLocalization
 */
class Category extends Model
{
    use NestableTrait;
    protected $primaryKey = 'id';
    protected $parent = 'parent_id';
    public $timestamps = false;
    private $array_id;

    public function DataLocalization() {
        return $this->hasMany('App\DataCategory', 'category_id');
    }

    protected function GetItem($id) {
        return Category::find($id);
    }

    public static function GetTree($select, $output) {
        $data = DB::table('data_categories')
            ->join('categories', 'data_categories.category_id', '=', 'categories.id')
            ->where('data_categories.lang_id', 1)
            ->orderBy('categories.sorting_order', 'asc')
            ->select(
                'categories.id',
                'categories.parent_id',
                'data_categories.name',
                'categories.slug'
            )
            ->get();

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
                    ->route(['categories/update' => 'id'])
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
        if ($parent_id == 0) {
            $data_insert += ['parent_id' => 1];
        } else {
            $data_insert += ['parent_id' => $parent_id];
        }
        return Category::insertGetId($data_insert);
    }

    protected function GetDataItem($id) {
        return Category::find($id);
    }
    protected function GetDataLocalization($id) {
        return Category::find($id)->DataLocalization;
    }

    protected function UpdateItem($id, $parent_id, $sorting_order) {
        $item = Category::find($id);
        $item->parent_id = $parent_id;
        $item->sorting_order = $sorting_order;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    private function DeleteItems() {
        Category::whereIn('id', $this->array_id)->delete();
        DataCategory::DeleteItems($this->array_id);
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
        $this->SearchId(Category::parent($id)->renderAsArray());
        $this->DeleteItems();
        return true;
    }
}
