<?php
namespace App\Traits\Models;
trait ProductTrait {
    /**
     * @return mixed
     */
    protected function Reviews() {
        return $this->hasMany('App\ProductReview', 'product_id');
    }

    /**
     * @return mixed
     */
    protected function Comments() {
        return $this->hasMany('App\ProductComment', 'product_id');
    }

    /**
     * @return mixed
     */
    protected function Categories() {
        return $this->hasMany('App\ProductCategory', 'product_id');
    }

    /**
     * @return mixed
     */
    protected function FilterColors() {
        return $this->hasMany('App\ProductFilterByColor', 'product_id');
    }

    /**
     * @return mixed
     */
    protected function Sizes() {
        return $this->hasMany('App\ProductSize', 'product_id');
    }

    /**
     * @return mixed
     */
    protected function ModularImages() {
        return $this->hasMany('App\ProductModularImage', 'product_id');
    }

    /**
     * @return mixed
     */
    protected function DataLocalization() {
        return $this->hasMany('App\DataProduct', 'product_id');
    }
}