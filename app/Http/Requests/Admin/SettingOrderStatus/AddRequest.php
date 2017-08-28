<?php

namespace App\Http\Requests\Admin\SettingOrderStatus;

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
            'name' => 'required|string|max:255|unique:setting_order_statuses,name'
        ];
    }
    public function messages ()
    {
        return [
            'name.required' => 'Наименование обязательно для заполнения',
            'name.string' => 'Наименование должно быть текстом',
            'name.max' => 'Наименование не должно превышать 255 символов',
            'name.unique' => 'Это Наименование уже существует в БД',
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
