<?php

namespace App\Http\Requests\OrderPrintPicture;

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
            'id' => 'required|integer|exists:order_print_pictures,id',
            'processing_status' => 'required|integer|exists:setting_order_statuses,id',
            'tel' => 'required|string|max:150',
            'width' => 'required|integer|between:1,9999',
            'height' => 'required|integer|between:1,9999',
            'canvas' => 'required|boolean'
        ];
    }

    public function messages() {
        return [
            'tel.required' => 'Вы не указали Телефон',
            'tel.max' => 'Телефон не должен превышать 150 символов',
            'width.required' => 'Вы не указали Ширину',
            'width.integer' => 'Ширина должна быть челочисленного значения',
            'width.between' => 'Ширина должна быть в промужутку между 1 и 9999',
            'height.required' => 'Вы не указали Высоту',
            'height.integer' => 'Высота должна быть челочисленного значения',
            'height.between' => 'Высота должна быть в промужутку между 1 и 9999',
            'canvas.required' => 'Вы не указали полотно',
            'canvas.boolean' => 'Полотно должно быть логическим значением'
        ];
    }

    public function response(array $errors) {
        if ($this->expectsJson()) {
            $response = [
                'errors' => $errors
            ];

            return response()->json($response, 422);
        }
    }
}
