<?php

namespace App\Http\Requests\Admin\ProductComment;

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
            'email' => 'nullable|email',
            'vendor_code' => 'nullable|integer|exists:products,vendor_code',
            'text_search' => 'nullable|string|max:255',
            'check_status' => 'nullable|integer|between:1,2',
            'read_status' => 'nullable|integer',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
        ];
    }
    public function messages ()
    {
        return [
            'email.email' => 'E-mail автора имеет не верный формат',
            'vendor_code.integer' => 'Артикул товара должен быть целочисленным значением',
            'vendor_code.exists' => 'Товара с данным артикулом не существует',
            'text_search.string' => 'Текст поиска имеет не верный формат',
            'text_search.max' => 'Текст поиска не должен превышать 255 символов',
            'check_status.integer' => 'Статус должен быть целочисленным значением',
            'check_status.between' => 'Статус должен быть в пределах значения от 1 до 2',
            'read_status.integer' => 'Значение "Только новые" должно быть целочисленным',
            'date_start.date' => 'Дата "От" имеет не верный формат',
            'date_end.date' => 'Дата "До" имеет не верный формат',
        ];
    }
}
