<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\UpdateRequest;
use App\Traits\CacheTrait;

class ContactController extends Controller {

    use CacheTrait;

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'Contact';
        $this->method_cache = 'GetData';
        $this->key_cache = 'contact';
    }
    
    public function Get() {
        return response()->json($this->GetOrCreateItemFromCache());
    }

    
    public function Update(UpdateRequest $request) {
        
        Contact::UpdateItem($request->email, $request->tel, $request->address);
        $this->ForgetItemInCache();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
