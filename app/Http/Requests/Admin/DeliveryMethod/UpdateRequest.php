<?php

namespace App\Http\Requests\Admin\DeliveryMethod;

use App\Base\FormRequestBase;
use App\Traits\FormRequests\Admin\DeliveryMethodTrait;

class UpdateRequest extends FormRequestBase
{
    use DeliveryMethodTrait;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->GenerateRules();

        $this->rules_local['item_id'] = 'required|integer|exists:delivery_methods,id';
        $this->messages_local['item_id.required'] = 'Не указан ID Метода доставки';
        $this->messages_local['item_id.integer'] = 'ID Метода доставки должен быть целочисленным';
        $this->messages_local['item_id.exists'] = 'Метод доставки не существует';
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
