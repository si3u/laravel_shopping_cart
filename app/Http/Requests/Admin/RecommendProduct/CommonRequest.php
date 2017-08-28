<?php

namespace App\Http\Requests\Admin\RecommendProduct;

use Illuminate\Foundation\Http\FormRequest;

class CommonRequest extends FormRequest
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
            'check_products.*' => 'nullable|integer'
        ];
    }
    public function messages ()
    {
        return [
            'check_products.*.integer' => 'Один с переданных идентификаторов не является целочисленным',
        ];
    }
}
