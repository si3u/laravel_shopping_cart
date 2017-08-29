<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\UpdateRequest;

class ContactController extends Controller {
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function Get() {
        return response()->json(Contact::GetData());
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Update(UpdateRequest $request) {
        Contact::UpdateItem($request->email, $request->tel, $request->address);
        return response()->json([
            'status' => 'success'
        ]);
    }
}