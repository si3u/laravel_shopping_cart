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
            'text_message' => 'required|string|max:2000',
            'name' => 'required|string|max:255'
        ];
    }
    public function messages ()
    {
        return [
            'title.required' => __('contacts.validation.title.required'),
            'title.string' => __('contacts.validation.title.string'),
            'title.max' => __('contacts.validation.title.max'),
            'email.required' => __('contacts.validation.email.required'),
            'email.email' => __('contacts.validation.email.email'),
            'email.max' => __('contacts.validation.email.max'),
            'text_message.required' => __('contacts.validation.text_message.required'),
            'text_message.string' => __('contacts.validation.text_message.string'),
            'text_message.max' => __('contacts.validation.text_message.max'),
            'name.required' => __('contacts.validation.name.required'),
            'name.string' => __('contacts.validation.name.string'),
            'name.max' => __('contacts.validation.name.max'),
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
