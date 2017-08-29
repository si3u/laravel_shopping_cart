<?php

namespace App\Http\Requests\Mail;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'text_message' => 'required|string',
            'name' => 'required|string|max:255'
        ];
    }
    public function messages ()
    {
        return [
            'title.required' => 'Вы не указали Заголовок',
            'title.string' => 'Заголовок должен иметь текстовое значение',
            'title.max' => 'Заголовок не должен превышать 255 символов',
            'email.required' => 'Вы не указали E-mail',
            'email.email' => 'Не верный формат E-mail',
            'email.max' => 'E-mail не должен превышать 255 символов',
            'text_message.required' => 'Вы не ввели Сообщение',
            'text_message.string' => 'Сообщение должно иметь текстовое значение',
            'name.required' => 'Вы не указали свое Имя',
            'name.string' => 'Имя должно быть текстовым значением',
            'name.max' => 'Имя не должно превышать 255 символов',
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
