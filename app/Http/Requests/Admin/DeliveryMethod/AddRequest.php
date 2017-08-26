<?php

namespace App\Http\Requests\Admin\DeliveryMethod;

use App\Base\BaseFormRequest;

class AddRequest extends BaseFormRequest
{
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['name_'.$this->active_local[$i]->lang] = 'required|string';

            $this->messages_local['name_'.$this->active_local[$i]->lang.'.required'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть заполнено';
            $this->messages_local['name_'.$this->active_local[$i]->lang.'.string'] = 'Наименование ('.$this->active_local[$i]->lang.') должно быть текстовым значением';

            $i++;
        }

        $this->rules_local['payment_methods'] = 'required';
        $this->rules_local['payment_methods.*'] = 'integer|exists:payment_methods,id';

        $this->messages_local['payment_methods.required'] = 'Вы не выбрали Метода оплаты';
        $this->messages_local['payment_methods.*.integer'] = 'Значение Методов оплаты должно быть целочисленным';
        $this->messages_local['payment_methods.*.exists'] = 'Один с Методов оплаты не существует';
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
