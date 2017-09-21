<?php

namespace App\Http\Requests\Admin\Contact;

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
            'email' => 'required|string|max:255',
            'tel' => 'required|string|max:255',
            'address' => 'required|string'
        ];
    }
    public function messages ()
    {
        return [
            'email.required' => 'Вы не указали контактный E-mail',
            'tel.required' => 'Вы не указали контактный телефон',
            'address.required' => 'Вы не указали адресу',
            'email.string' => 'E-mail должен быть текстовым значением',
            'tel.string' => 'Телефон должен быть текстовым значением',
            'address.string' => 'Адрес должен быть текстовым значением',
            'email.max' => 'E-mail не должен превышать 255 символов',
            'tel.max' => 'Телефон не должен превышать 255 символов',
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
