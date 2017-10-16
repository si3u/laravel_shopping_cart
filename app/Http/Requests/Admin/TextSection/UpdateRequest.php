<?php

namespace App\Http\Requests\Admin\TextSection;

use App\Base\FormRequestBase;

class UpdateRequest extends FormRequestBase
{
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $i = 0;
        while ($i<$this->count_active_local) {
            $this->rules_local['value_'.$this->active_local[$i]->lang] = 'string|nullable';

            $this->messages_local['value_'.$this->active_local[$i]->lang.'.string'] = 'Значение ('.$this->active_local[$i]->lang.') должно быть текстовым значением';

            $i++;
        }
        $this->rules_local['section'] = 'required|string|exists:text_sections,section';
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
