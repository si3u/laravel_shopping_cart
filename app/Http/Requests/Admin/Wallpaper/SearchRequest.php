<?php

namespace App\Http\Requests\Admin\Wallpaper;

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
            'vendor_code' => 'nullable|integer',
            'status' => 'nullable|integer',
            'name' => 'nullable|string',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'category.*' => 'exists:categories,id'
        ];
    }
    public function messages ()
    {
        return [
            'vendor_code.integer' => 'Артикул должен быть целочисленным значением',
            'status.integer' => 'Статус должен быть целочисленным значением',
            'name.string' => 'Наименование должно быть текстом',
            'date_start.date' => 'Дата "От" имеет не верный формат',
            'date_end.date' => 'Дата "До" имеет не верный формат',
        ];
    }
}
