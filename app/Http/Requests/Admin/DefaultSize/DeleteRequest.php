<?php

namespace App\Http\Requests\Admin\DefaultSize;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
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
            'id' => 'required|integer|exists:default_sizes,id',
        ];
    }
    public function messages ()
    {
        return [
            'id.required' => 'Вы не передали ID элемента',
            'id.integer' => 'Значение ID должно быть целочисленным',
            'id.exists' => 'Даной записи не существует в БД',
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
