<?php
namespace App\Base;

use App\ActiveLocalization;
use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest {
    protected $rules_local;
    protected $messages_local;
    protected $active_local;
    protected $count_active_local;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->rules_local = []; $this->messages_local = [];
        $this->active_local = ActiveLocalization::GetActive();
        $this->count_active_local = count($this->active_local);
    }
}