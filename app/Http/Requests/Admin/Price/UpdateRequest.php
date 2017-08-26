<?php

namespace App\Http\Requests\Admin\Price;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'natural_canvas' => 'required|between:0,99999999.99',
            'artificial_canvas' => 'required|between:0,99999999.99',
            'running_meter' => 'required|between:0,99999999.99',
            'for_work' => 'required|between:0,99999999.99',
        ];
    }
    public function messages ()
    {
        return [
            'natural_canvas.required' => 'Цена "Натуральный холст" должна быть заполнена',
            'natural_canvas.between' => 'Цена "Натуральный холст" должна быть от 0 до 99999999.99',
            'artificial_canvas.required' => 'Цена "Искуственный холст" должна быть заполнена',
            'artificial_canvas.between' => 'Цена "Искуственный холст" должна быть от 0 до 99999999.99',
            'running_meter.required' => 'Цена "Погонный метр" должна быть заполнена',
            'running_meter.between' => 'Цена "Погонный метр" должна быть от 0 до 99999999.99',
            'for_work.required' => 'Цена "За работу" должна быть заполнена',
            'for_work.between' => 'Цена "За работу" должна быть от 0 до 99999999.99',
        ];
    }
}
