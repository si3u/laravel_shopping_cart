<?php
namespace App\Traits\FormRequests\Admin;

trait ImageTrait {
    private function ImageRules($required = false) {
        if ($required != false) {
            $this->rules_local['image'] = 'required|mimes:jpg,jpeg,png|max:2048';
        }
        else {
            $this->rules_local['image'] = 'mimes:jpg,jpeg,png|max:2048';
        }

        $this->messages_local['image.required'] = 'Вы не выбрали изображение';
        $this->messages_local['image.mimes'] = 'Допустимые разширения для изображения: jpg,jpeg, png';
        $this->messages_local['image.max'] = 'Изображение не должно превышать 2Мб.';
    }
}