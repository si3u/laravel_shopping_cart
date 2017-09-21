<?php

namespace App\Http\Requests\Admin\News;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
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
        return [
            'text' => 'nullable|string',
            'option' => 'nullable|integer|between:1,2',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
        ];
    }
    public function messages ()
    {
        return [
            'text.string' => 'Текст поиска должен быть текстовым значением',
            'option.integer' => 'Опция поиска должна быть целочисленным значением',
            'option.between' => 'Опция поиска должна бить быть в промежутку от 1 до 2',
            'date_start.date' => 'Дата "От" имеет не верный формат',
            'date_end.date' => 'Дата "До" имеет не верный формат',
        ];
    }
}
