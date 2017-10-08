<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\UpdateRequest;
use App\Traits\Controllers\Admin\ContactTrait;

class ContactController extends Controller {

    use ContactTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function Get() {
        return response()->json($this->GetItemFromCache());
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Update(UpdateRequest $request) {
        
        Contact::UpdateItem($request->email, $request->tel, $request->address);
        $this->ForgetItemInCache();

        return response()->json([
            'status' => 'success'
        ]);
    }
}