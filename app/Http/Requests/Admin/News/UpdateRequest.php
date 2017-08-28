<?php

namespace App\Http\Requests\Admin\News;

use App\Base\FormRequestBase;
use App\Traits\FormRequests\Admin\ImageTrait;
use App\Traits\FormRequests\Admin\NewsTrait;

class UpdateRequest extends FormRequestBase
{
    use NewsTrait;
    use ImageTrait;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->GenerateRules();
        $this->ImageRules();

        $this->rules_local['item_id'] = 'required|integer|exists:news,id';

        $this->messages_local['item_id.required'] = 'Вы не передали ID новости';
        $this->messages_local['item_id.integer'] = 'ID новости должен быть целочисленным значением';
        $this->messages_local['item_id.exists'] = 'Эта новости не существует в БД';
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
