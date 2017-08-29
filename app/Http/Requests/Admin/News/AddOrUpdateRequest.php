<?php

namespace App\Http\Requests\Admin\News;

use App\Base\FormRequestBase;

class AddOrUpdateRequest extends FormRequestBase
{
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['topic_'.$this->active_local[$i]->lang] = 'required|string|max:255';
            $this->rules_local['text_'.$this->active_local[$i]->lang] = 'required|string';
            $this->rules_local['meta_title_'.$this->active_local[$i]->lang] = 'nullable|string|max:255';
            $this->rules_local['meta_description_'.$this->active_local[$i]->lang] = 'nullable|string';
            $this->rules_local['meta_keywords_'.$this->active_local[$i]->lang] = 'nullable|string';
            $this->rules_local['tags_'.$this->active_local[$i]->lang] = 'nullable|string';

            $this->messages_local['topic_'.$this->active_local[$i]->lang.'.required'] = 'Вы не указали Наименование ('.$this->active_local[$i]->lang.')';
            $this->messages_local['topic_'.$this->active_local[$i]->lang.'.string'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть текстовым значением';
            $this->messages_local['topic_'.$this->active_local[$i]->lang.'.max'] = 'Наименование ('.$this->active_local[$i]->lang.') не должно превышать 255 символов';
            $this->messages_local['text_'.$this->active_local[$i]->lang.'.required'] = 'Вы не указали  Тект новости ('.$this->active_local[$i]->lang.')';
            $this->messages_local['text_'.$this->active_local[$i]->lang.'.string'] = 'Тект новости ('.$this->active_local[$i]->lang.') должен быть текстовым значением';
            $this->messages_local['meta_title_'.$this->active_local[$i]->lang.'.string'] = 'Meta Title ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['meta_title_'.$this->active_local[$i]->lang.'.max'] = 'Meta Title ('.$this->active_local[$i]->lang.') - поле не должно превышать 255 символов';
            $this->messages_local['meta_description_'.$this->active_local[$i]->lang.'.string'] = 'Meta Description ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['meta_keywords_'.$this->active_local[$i]->lang.'.string'] = 'Meta Keywords ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';
            $this->messages_local['tags_'.$this->active_local[$i]->lang.'.string'] = 'Теги ('.$this->active_local[$i]->lang.') - поле должно быть текстовым значением';

            $i++;
        }
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
        if ($this->route()->getName() == 'news/add') {
            $this->rules_local['image'] = 'required|mimes:jpg,jpeg,png|max:2048';
            $this->messages_local['image.required'] = 'Вы не выбрали изображение';
        }
        else {
            $this->rules_local['image'] = 'mimes:jpg,jpeg,png|max:2048';
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
