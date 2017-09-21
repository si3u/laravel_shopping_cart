<?php

namespace App\Http\Requests\Admin\ProductReview;

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
            'vendor_code' => 'nullable|integer|exists:products,vendor_code',
            'email' => 'nullable|email',
            'text_search' => 'nullable|string',
            'check_status' => 'nullable|integer',
            'read_status' => 'nullable|integer',
            'score' => 'nullable|integer',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date'
        ];
    }
    public function messages ()
    {
        return [
            'vendor_code.integer' => 'Артикул товара должен быть целочисленным значением',
            'vendor_code.exists' => 'Товара с этим Артикулом не существует',
            'email.email' => 'E-mail имеет не верный формат',
            'text_search.string' => 'Текст поиска должен быть текстовым значением',
            'check_status.integer' => 'Статус должен быть целочисленным значением',
            'read_status.integer' => 'Статус новых отзывов должен быть целочисленным значением',
            'score.integer' => 'Рейтин должен быть целочисленным значением',
            'date_start.date' => 'Дата "От" имеет не верный формат',
            'date_end.date' => 'Дата "До" имеет не верный формат',
        ];
    }
}
