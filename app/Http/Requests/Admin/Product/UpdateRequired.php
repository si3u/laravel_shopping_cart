<?php

namespace App\Http\Requests\Admin\Product;

use App\Base\FormRequestBase;
use App\Traits\FormRequests\Admin\ImageTrait;
use App\Traits\FormRequests\Admin\ProductTrait;

class UpdateRequired extends FormRequestBase
{
    use ProductTrait;
    use ImageTrait;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->rules_local['item_id'] = 'required|integer|exists:products,id';

        $this->messages_local['item_id.required'] = 'Вы не передали ID товара';
        $this->messages_local['item_id.integer'] = 'ID товара должен быть целочисленным';
        $this->messages_local['item_id.exists'] = 'Товара с данным ID не существует';

        $this->GenerateRules();
        $this->ImageRules();
    }

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
        return $this->rules_local;
    }
    public function messages ()
    {
        return $this->messages_local;
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
