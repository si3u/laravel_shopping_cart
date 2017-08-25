<?php
namespace App\Traits\Models;
trait ProductTrait {
    protected function Reviews() {
        return $this->hasMany('App\ProductReview', 'product_id');
    }
    protected function Comments() {
        return $this->hasMany('App\ProductComment', 'product_id');
    }

    protected function Categories() {
        return $this->hasMany('App\ProductCategory', 'product_id');
    }

    protected function FilterColors() {
        return $this->hasMany('App\ProductFilterByColor', 'product_id');
    }

    protected function Sizes() {
        return $this->hasMany('App\ProductSize', 'product_id');
    }

    protected function ModularImages() {
        return $this->hasMany('App\ProductModularImage', 'product_id');
    }

    protected function DataLocalization() {
        return $this->hasMany('App\DataProduct', 'product_id');
    }
}