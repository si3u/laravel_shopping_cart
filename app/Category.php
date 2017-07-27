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
 */
class Category extends Model
{
    use NestableTrait;
    protected $primaryKey = 'id';
    protected $parent = 'parent_id';

    protected function GetSlug($id) {
        return Category::find($id)->select('slug');
    }

    protected function SearchSlug($slug) {
        return Category::where('slug', $slug)->count();
    }

    protected function GetItem($id) {
        return Category::find($id);
    }

    protected function GetLastItemId() {
        return DB::table('categories')->orderBy('id', 'desc')->first();
    }

    protected function GetSelectCategories($select) {
        return Category::attr([
                'class' => 'form-control',
                'name' => 'parent_id',
                'id' => 'parent_id'
            ])
            ->selected($select)->orderBy('sorting_order', 'asc')
            ->renderAsDropdown();
    }

    protected function AddItem($name,
                               $slug,
                               $description = null,
                               $meta_title = null,
                               $meta_description = null,
                               $meta_keywords = null,
                               $sorting_order,
                               $parent_id) {
        $item = new Category();
        $item->name = $name;
        $item->slug = $slug;
        if ($description != null) {
            $item->description = $description;
        }
        if ($meta_title != null) {
            $item->meta_title = $meta_title;
        }
        if ($meta_description != null) {
            $item->meta_description = $meta_description;
        }
        if ($meta_keywords != null) {
            $item->meta_keywords = $meta_keywords;
        }
        $item->sorting_order = $sorting_order;

        if ($parent_id == 1) {
            $item->parent_id = 0;
        }
        else {
            $item->parent_id = $parent_id;
        }

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function UpdateItem($id,
                                $name,
                                $slug,
                                $description,
                                $meta_title,
                                $meta_description,
                                $meta_keywords,
                                $sorting_order,
                                $parent_id) {
        $item = Category::find($id);
        $item->name = $name;
        $item->slug = $slug;
        $item->description = $description;
        $item->meta_title = $meta_title;
        $item->meta_description = $meta_description;
        $item->meta_keywords = $meta_keywords;
        $item->sorting_order = $sorting_order;
        if ($parent_id == 1) {
            $item->parent_id = 0;
        }
        else {
            $item->parent_id = $parent_id;
        }

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function DeleteItem($id) {

    }
}
