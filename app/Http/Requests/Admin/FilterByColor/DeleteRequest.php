<?php

namespace App\Http\Requests\Admin\FilterByColor;

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
            'id' => 'required|integer|exists:filter_by_colors,id'
        ];
    }
    public function messages ()
    {
        return [
            'id.required' => 'Вы не указали ID фильтра',
            'id.integer' => 'ID фильтра должен быть целоцисленным значением',
            'id.exists' => 'Этот фильтер не существует',
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
