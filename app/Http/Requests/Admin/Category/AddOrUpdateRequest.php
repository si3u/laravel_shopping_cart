<?php

namespace App\Http\Requests\Admin\Category;

use App\Base\FormRequestBase;

class AddOrUpdateRequest extends FormRequestBase
{
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['name_'.$this->active_local[$i]->lang] = 'required|string';
            $this->rules_local['sorting_order_'.$this->active_local[$i]->lang] = 'required|integer';
            $this->rules_local['description_'.$this->active_local[$i]->lang] = 'string|nullable';
            $this->rules_local['meta_title_'.$this->active_local[$i]->lang] = 'string|nullable';
            $this->rules_local['meta_description_'.$this->active_local[$i]->lang] = 'string|nullable';
            $this->rules_local['meta_keywords_'.$this->active_local[$i]->lang] = 'string|nullable';

            $this->messages_local['name_'.$this->active_local[$i]->lang.'.required'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть заполненым';
            $this->messages_local['name_'.$this->active_local[$i]->lang.'.string'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть текстовым значением';
            $this->messages_local['sorting_order_'.$this->active_local[$i]->lang.'.required'] = 'Порядок сортировки должен быть заполнен';
            $this->messages_local['sorting_order_'.$this->active_local[$i]->lang.'.integer'] = 'Порядок сортировки должен быть целочисленным значением';
            $this->messages_local['description_'.$this->active_local[$i]->lang.'.string'] = 'Описание ('.$this->active_local[$i]->lang.') должен быть текстовым значением';
            $this->messages_local['meta_title_'.$this->active_local[$i]->lang.'.string'] = 'Мета-тег Title ('.$this->active_local[$i]->lang.') должен быть текстовым значением';
            $this->messages_local['meta_description_'.$this->active_local[$i]->lang.'.string'] = 'Мета-тег Description ('.$this->active_local[$i]->lang.') должен быть текстовым значением';
            $this->messages_local['meta_keywords_'.$this->active_local[$i]->lang.'.string'] = 'Мета-тег Keywords ('.$this->active_local[$i]->lang.') должен быть текстовым значением';

            $i++;
        }

        $this->rules_local['parent_id'] = 'required|integer|exists:categories,id';
        $this->messages_local['parent_id.required'] = 'Укажите ID родительской категории';
        $this->messages_local['parent_id.integer'] = 'ID родительской категории должен быть целочисленным значением';
        $this->messages_local['parent_id.exists'] = 'ID родительской категории не существует в БД';
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
        if ($this->route()->getName() == 'categories/update') {
            $this->messages_local['item_id.required'] = 'Укажите ID категории';
            $this->messages_local['item_id.integer'] = 'ID категории должен быть целочисленным значением';
            $this->messages_local['item_id.exists'] = 'ID категории не существует в БД';
        }

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
