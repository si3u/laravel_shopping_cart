<?php

namespace App\Http\Requests\Admin\PaymentMethod;

use App\Base\FormRequestBase;

class UpdateRequest extends FormRequestBase
{
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['name_'.$this->active_local[$i]->lang] = 'required|string|max:255';

            $this->messages_local['name_'.$this->active_local[$i]->lang.'.required'] = 'Вы не указали Наименование ('.$this->active_local[$i]->lang.')';
            $this->messages_local['name_'.$this->active_local[$i]->lang.'.string'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть текстовым значением';
            $this->messages_local['name_'.$this->active_local[$i]->lang.'.max'] = 'Наименование ('.$this->active_local[$i]->lang.') не должно превышать 255 символов';

            $i++;
        }

        $this->rules_local['item_id'] = 'required|integer|exists:payment_methods,id';
        $this->messages_local['item_id.required'] = 'Вы не указали ID Метода оплаты';
        $this->messages_local['item_id.integer'] = 'ID Метода оплаты должен быть целочисленным значением';
        $this->messages_local['item_id.exists'] = 'Этот Метод оплаты не существует в БД';
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
