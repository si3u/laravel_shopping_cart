<?php

namespace App\Http\Requests\Admin\Contact;

use App\Base\FormRequestBase;

class UpdateRequest extends FormRequestBase
{
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['addresses_'.$this->active_local[$i]->lang] = 'string|nullable|max:1000';
            $this->rules_local['working_days_'.$this->active_local[$i]->lang] = 'string|nullable|max:1000';

            $this->messages_local['addresses_'.$this->active_local[$i]->lang.'.string'] = 'Адрес ('.$this->active_local[$i]->lang.') должен быть текстовым значением';
            $this->messages_local['addresses_'.$this->active_local[$i]->lang.'.max'] = 'Адрес ('.$this->active_local[$i]->lang.') не должен превышать 1000 символов';
            $this->messages_local['working_days_'.$this->active_local[$i]->lang.'.string'] = 'Рабочие дни ('.$this->active_local[$i]->lang.') поле должно быть текстовым значением';
            $this->messages_local['working_days_'.$this->active_local[$i]->lang.'.max'] = 'Рабочие дни ('.$this->active_local[$i]->lang.') поле не должно превышать 1000 символов';

            $i++;
        }
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
        $this->rules_local['tel'] = 'string|nullable|max:1000';
        $this->rules_local['email'] = 'email|nullable|max:1000';

        return $this->rules_local;
    }
    public function messages ()
    {
        $this->messages_local['tel.srting'] = 'Телефон должен быть текстовым значением';
        $this->messages_local['tel.max'] = 'Телефон не должен превышать 1000 символов';
        $this->messages_local['email.email'] = 'E-mail неверного формата';
        $this->messages_local['email.max'] = 'E-mail не должен превышать 1000 символов';

        return $this->messages_local;
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
