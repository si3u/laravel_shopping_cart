<?php

namespace App\Http\Requests\Admin\SizeModularImage;

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
            'id' => 'required|integer|exists:size_modular_images,id'
        ];
    }

    public function messages ()
    {
        return [
            'id.required' => 'Вы не передали ID размера',
            'id.integer' => 'ID размера должен быть целочисленным значением',
            'id.exists' => 'Размера с данным ID не существует',
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
