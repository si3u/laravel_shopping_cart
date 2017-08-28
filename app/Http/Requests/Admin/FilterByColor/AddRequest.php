<?php

namespace App\Http\Requests\Admin\FilterByColor;

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
            'name' => 'required|string|max:255|unique:filter_by_colors,name',
            'hex' => 'required|string|max:255|unique:filter_by_colors,hex',
        ];
    }
    public function messages ()
    {
        return [
            'name.required' => 'Вы не указали Наименование',
            'name.string' => 'Наименование должно быть текстовым значением',
            'name.max' => 'Наименование не должно быть больше 255 символов',
            'name.unique' => 'Это Наименование уже существует в БД',
            'hex.required' => 'Вы не указали Цвет',
            'hex.string' => 'Цвет должен быть текстовым значением',
            'hex.max' => 'Цвет не должно превышать 255 символов',
            'hex.unique' => 'Этот Цвет уже существует в БД',
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
