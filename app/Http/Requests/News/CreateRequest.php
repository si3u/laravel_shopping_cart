<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'news_id' => 'required|integer|exists:news,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000'
        ];
    }

    public function messages() {
        return [
            'news_id.required' => __('news.comment.validation.news_id.required'),
            'news_id.integer' => __('news.comment.validation.news_id.integer'),
            'news_id.exists' => __('news.comment.validation.news_id.exists'),
            'name.required' => __('news.comment.validation.name.required'),
            'name.string' => __('news.comment.validation.name.string'),
            'name.max' => __('news.comment.validation.name.max'),
            'email.required' => __('news.comment.validation.email.required'),
            'email.email' => __('news.comment.validation.email.email'),
            'email.max' => __('news.comment.validation.email.max'),
            'message.required' => __('news.comment.validation.message.required'),
            'message.string' => __('news.comment.validation.message.string'),
            'message.max' => __('news.comment.validation.message.max')
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
