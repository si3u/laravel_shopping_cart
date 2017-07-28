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
 */
class Category extends Model
{
    use NestableTrait;
    protected $primaryKey = 'id';
    protected $parent = 'parent_id';
    public $timestamps = false;

    protected function GetParentItem($id) {

    }
    protected function GetTree($select, $lang) {
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

        return $result->attr([
                'class' => 'form-control',
                'name' => 'parent_id',
                'id' => 'parent_id'
            ])->selected($select)->renderAsDropdown();
    }
    protected function GetLastItem() {
        return DB::table('categories')->orderBy('id', 'desc')->first();
    }
    protected function CreateItem($slug,
                                  $parent_id,
                                  $sorting_order) {
        $item = new Category();
        $item->slug = $slug;
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
}
