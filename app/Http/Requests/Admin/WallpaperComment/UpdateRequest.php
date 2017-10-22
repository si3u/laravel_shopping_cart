<?php

namespace App\Http\Requests\Admin\ProductComment;

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
            'id' => 'required|integer|exists:wallpaper_comments,id',
            'status' => 'required|boolean',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'message' => 'required|string'
        ];
    }
    public function messages ()
    {
        return [
            'id.required' => 'Вы не передали ID комментария',
            'id.integer' => 'ID комментария должен быть целочисленным значением',
            'id.exists' => 'Данный комментарий не существует',
            'status.required' => 'Вы не указали Статус',
            'status.boolean' => 'Статус должен иметь логический тип',
            'name.required' => 'Вы не указали Автора',
            'name.string' => 'Автор - значение должно быть текстовым',
            'name.max' => 'Автор - значение не должно превышать 255 символов',
            'email.required' => 'Вы не указали E-mail автора',
            'email.string' => 'E-mail автора - значение должно быть текстовым',
            'email.max' => 'E-mail автора - значение не должно превышать 255 символов',
            'message.required' => 'Вы не указали Текст комментария',
            'message.string' => 'Текст комментария - значение должно быть текстовым'
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
