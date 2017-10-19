<?php

namespace App\Http\Requests\OrderPrintPicture;

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
            'tel' => 'required|string|max:150',
            'width' => 'required|integer|between:1,9999',
            'height' => 'required|integer|between:1,9999',
            'canvas' => 'required|boolean',
            'file' => 'required|mimes:jpg,jpeg,png,tiff,psd,eps,ai,rar,zip|max:5000'
        ];
    }

    public function messages() {
        return [
            'tel.required' => __('create_print.tel.required'),
            'tel.string' => __('create_print.tel.string'),
            'tel.max' => __('create_print.tel.max'),
            'width.required' => __('create_print.width.required'),
            'width.integer' => __('create_print.width.integer'),
            'width.between' => __('create_print.width.between'),
            'height.required' => __('create_print.height.required'),
            'height.integer' => __('create_print.height.integer'),
            'height.between' => __('create_print.height.between'),
            'canvas.required' => __('create_print.canvas.required'),
            'canvas.boolean' => __('create_print.canvas.boolean'),
            'file.required' => __('create_print.file.required'),
            'file.mimes' => __('create_print.file.mimes'),
            'file.max' => __('create_print.file.max')
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
