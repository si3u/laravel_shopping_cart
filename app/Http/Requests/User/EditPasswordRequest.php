<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'now_pass' => 'required|min:5|max:32|alpha_num',
            'new_pass1' => 'required|min:8|max:32|alpha_num',
            'new_pass2' => 'required|min:8|max:32|alpha_num'
        ];
    }

    public function messages () {
        return [
            'now_pass.required' => 'Вы не ввели нынешний пароль',
            'now_pass.min' => 'Нынешний пароль должен быть больше 5 символов',
            'now_pass.max' => 'Нынешний пароль не должен превышать 32 символа',
            'now_pass.alpha_num' => 'Нынешний пароль содержит неверные символы',

            'new_pass1.required' => 'Вы не ввели новый пароль (поле 1)',
            'new_pass1.min' => 'Новый пароль (поле 1) должен быть больше 8 символов',
            'new_pass1.max' => 'Новый пароль (поле 1) не должен превышать 32 символа',
            'new_pass1.alpha_num' => 'Новый пароль (поле 1) содержит неверные символы',

            'new_pass2.required' => 'Вы не ввели новый пароль (поле 2)',
            'new_pass2.min' => 'Новый пароль (поле 2) должен быть больше 8 символов',
            'new_pass2.max' => 'Новый пароль (поле 2) не должен превышать 32 символа',
            'new_pass2.alpha_num' => 'Новый пароль (поле 2) содержит неверные символы',
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