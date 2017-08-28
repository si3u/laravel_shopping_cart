<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\UpdateRequest;

class ContactController extends Controller {
    public function Get() {
        return response()->json(Contact::GetData());
    }

    public function Update(UpdateRequest $request) {
        Contact::UpdateItem($request->email, $request->tel, $request->address);
        return response()->json([
            'status' => 'success'
        ]);
    }
}