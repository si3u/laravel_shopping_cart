<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
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
            'login' => 'required|max:16|alpha_dash',
            'password' => 'required|min:5|max:32|alpha_num',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    public function messages () {
        return [
            'login.required' => 'Вы не указали Логин',
            'login.max' => 'Логин не должен превышать 16 символов',
            'login.alpha_dash' => 'Логин может содержать только буквы, цифры и дефис.',
            'password.required' => 'Вы не указали Пароль',
            'password.min' => 'Пароль должен быть больше 5 символов',
            'password.max' => 'Пароль не должен превышать 32 символа',
            'password.alpha_num' => 'Пароль может содержать только буквы и цифры.',
            'g-recaptcha-response.required' => 'Кликните на "Я не робот" и пройдите проверку',
            'g-recaptcha-response.captcha' => 'Неверные данные Google reCAPTCHA'
        ];
    }
}