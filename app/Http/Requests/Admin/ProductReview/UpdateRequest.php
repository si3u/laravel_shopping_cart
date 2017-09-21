<?php

namespace App\Http\Requests\Admin\ProductReview;

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
            'id' => 'required|integer|exists:product_reviews,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'score' => 'required|integer|between:1,5',
            'status' => 'required|boolean'
        ];
    }
    public function messages ()
    {
        return [
            'name.required' => 'Вы не указали Имя автора',
            'name.string' => 'Имя автора должно быть текстовым значением',
            'name.max' => 'Имя автора не должно превышать 255 символов',
            'email.required' => 'Вы не указали E-mail автора',
            'email.email' => 'E-mail автора имеет не верный формат',
            'message.required' => 'Вы не указали текст Сообщения',
            'message.string' => 'Сообщение должно иметь текстовое значение',
            'score.required' => 'Вы не указали Рейтинг',
            'score.integer' => 'Рейтинг должен быть целочисленным значением',
            'score.between' => 'Рейтинг должен быть в диапазоне от 1 до 5',
            'status.required' => 'Вы не указали Статус',
            'status.boolean' => 'Статус должен имееть логическое значение',
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
