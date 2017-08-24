<?php

namespace App\Http\Requests\Admin\DefaultSize;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
            'width' => 'required|integer',
            'height' => 'required|integer'
        ];
    }
    public function messages ()
    {
        return [
            'width.required'       => 'Укажите значение ширены',
            'height.required' => 'Укажите значение вытоты',
            'width.integer'       => 'Ширина должна быть целочисленным значением',
            'height.integer' => 'Высота должна быть челочисленным значением',
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
