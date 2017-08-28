<?php

namespace App\Http\Requests\Admin\ModularImage;

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
            'file' => 'required|mimes:jpg,jpeg,png|max:2048'
        ];
    }
    public function messages ()
    {
        return [
            'file.required' => 'Вы не передали изображение Модуля',
            'file.mimes' => 'Изображение должно иметь расширение: jpg,jpeg,png',
            'file.max' => 'Изображение не должно превышать 2Мб.'
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
