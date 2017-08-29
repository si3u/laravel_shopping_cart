<?php

namespace App\Http\Requests\Admin\Product;

use App\Base\FormRequestBase;

class AddOrUpdateRequest extends FormRequestBase
{
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['name_'.$this->active_local[$i]->lang] = 'required|string|max:255';
            $this->rules_local['meta_title_'.$this->active_local[$i]->lang] = 'nullable|string|max:255';
            $this->rules_local['meta_description_'.$this->active_local[$i]->lang] = 'nullable|string';
            $this->rules_local['meta_keywords_'.$this->active_local[$i]->lang] = 'nullable|string';
            $this->rules_local['tags_'.$this->active_local[$i]->lang] = 'nullable|string';

            $this->messages_local['name_'.$this->active_local[$i]->lang.'.required'] = 'Вы не указали Наименование ('.$this->active_local[$i]->lang.')';
            $this->messages_local['name_'.$this->active_local[$i]->lang.'.string'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть текстовым значением';
            $this->messages_local['name_'.$this->active_local[$i]->lang.'.max'] = 'Наименование ('.$this->active_local[$i]->lang.') не должно превышать 255 символов';
            $this->messages_local['meta_title_'.$this->active_local[$i]->lang.'.string'] = 'Meta Title ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['meta_title_'.$this->active_local[$i]->lang.'.max'] = 'Meta Title ('.$this->active_local[$i]->lang.') - поле не должно превышать 255 символов';
            $this->messages_local['meta_description_'.$this->active_local[$i]->lang.'.string'] = 'Meta Description ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['meta_keywords_'.$this->active_local[$i]->lang.'.string'] = 'Meta Keywords ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['tags_'.$this->active_local[$i]->lang.'.string'] = 'Теги ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';

            $i++;
        }

        $this->rules_local['vendor_code'] = 'required|integer|unique:products,vendor_code';
        $this->rules_local['min_width'] = 'required|integer';
        $this->rules_local['max_width'] = 'required|integer';
        $this->rules_local['min_height'] = 'required|integer';
        $this->rules_local['max_height'] = 'required|integer';
        $this->rules_local['category'] = 'required';
        $this->rules_local['category.*'] = 'integer|exists:categories,id';
        $this->rules_local['size'] = 'required';
        $this->rules_local['size.*'] = 'integer|exists:default_sizes,id';
        $this->rules_local['color.*'] = 'nullable|integer|exists:filter_by_colors,id';
        $this->rules_local['status'] = 'required|boolean';

        $this->messages_local['vendor_code.required'] = 'Вы не ввели Артикел товара';
        $this->messages_local['vendor_code.integer'] = 'Артикул товара должен быть целочисленным значением';
        $this->messages_local['vendor_code.unique'] = 'Товар с этим Артикулом уже существует';
        $this->messages_local['min_width.required'] = 'Вы не указали Минимальную ширину';
        $this->messages_local['min_width.integer'] = 'Минимальная ширина должена быть целочисленным значением';
        $this->messages_local['max_width.required'] = 'Вы не указали Максимальную ширину';
        $this->messages_local['max_width.integer'] = 'Максимальная ширина должена быть целочисленным значением';
        $this->messages_local['min_height.required'] = 'Вы не указали Минимальную висоту';
        $this->messages_local['min_height.integer'] = 'Минимальная висота должена быть целочисленным значением';
        $this->messages_local['max_height.required'] = 'Вы не указали Максимальную высоту';
        $this->messages_local['max_height.integer'] = 'Максимальная высота должена быть целочисленным значением';
        $this->messages_local['category.required'] = 'Вы не выбрали ни одной Категории для товара';
        $this->messages_local['category.*.integer'] = 'ID Категории должен быть целочисленным значением';
        $this->messages_local['size.required'] = 'Вы не выбрали размеры товара';
        $this->messages_local['size.*.integer'] = 'ID размера товара должен быть целочисленным значением';
        $this->messages_local['color.*.integer'] = 'ID фильтра по цвету должен быть целочисленным значением';
        $this->messages_local['status.required'] = 'Вы не передали Статус отображения товара';
        $this->messages_local['status.boolean'] = 'Статус отображения должен быть логическим значением';

        $this->ImageRules(true);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->route()->getName() == 'product/update') {
            $this->rules_local['item_id'] = 'required|integer|exists:products,id';
            $this->rules_local['image'] = 'mimes:jpg,jpeg,png|max:2048';

            $this->messages_local['image.required'] = 'Вы не выбрали изображение';
            $this->messages_local['item_id.required'] = 'Вы не передали ID товара';
            $this->messages_local['item_id.integer'] = 'ID товара должен быть целочисленным';
            $this->messages_local['item_id.exists'] = 'Товара с данным ID не существует';
        }
        else {
            $this->rules_local['image'] = 'required|mimes:jpg,jpeg,png|max:2048';
        }
        $this->messages_local['image.mimes'] = 'Допустимые разширения для изображения: jpg,jpeg, png';
        $this->messages_local['image.max'] = 'Изображение не должно превышать 2Мб.';

        return $this->rules_local;
    }
    public function messages ()
    {
        return $this->messages_local;
    }
    public function response(array $errors) {
        if ($this->expectsJson()) {
            $response = [
                'errors' => $errors
            ];

            return response()->json($response, 422);
        }
        return false;
    }
}
