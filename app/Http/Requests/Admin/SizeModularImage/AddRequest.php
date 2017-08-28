<?php

namespace App\Http\Requests\Admin\SizeModularImage;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'modular_id' => 'required|integer|exists:modular_images,id',
            'number' => 'required|integer',
            'width' => 'required|integer',
            'height' => 'required|integer'
        ];
    }

    public function messages ()
    {
        return [
            'number.required' => 'Вы не указали Порядковый номер картины',
            'number.integer' => 'Порядковый номер картины должен быть целочисленным',
            'width.required' => 'Вы не указали Ширину',
            'width.integer' => 'Ширина должна быть целочисленным значением',
            'height.required' => 'Вы не указали Высоту',
            'height.integer' => 'Высота должна быть целочисленным значением',
        ];
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
