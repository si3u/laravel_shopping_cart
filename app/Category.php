<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $category_name
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
 */
class Category extends Model
{
    protected $primaryKey = 'id';

    protected function GetLastItemId() {
        return Category::orderBy('id', 'desc')->select('id')->first();
    }

    protected function AddItem($name,
                               $description = null,
                               $meta_title = null,
                               $meta_description = null,
                               $meta_keywords = null,
                               $sorting_order = null,
                               $parent_id = null) {
        $item = new Category();
        $item->category_name = $name;
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
        if ($sorting_order != null) {
            $item->sorting_order = $sorting_order;
        }
        if ($parent_id != null) {
            $item->parent_id = $parent_id;
        }

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function EditItem($id,
                                $name,
                                $description = null,
                                $meta_title = null,
                                $meta_description = null,
                                $meta_keywords = null,
                                $sorting_order = null,
                                $parent_id = null) {
        $item = Category::find($id);
        $item->category_name = $name;
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
        if ($sorting_order != null) {
            $item->sorting_order = $sorting_order;
        }
        if ($parent_id != null) {
            $item->parent_id = $parent_id;
        }

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function GetAllChildElements($id) {

    }

    protected function DeleteItem($id) {

    }
}
