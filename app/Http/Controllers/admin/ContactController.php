<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller {
    public function Get() {
        return response()->json(Contact::GetData());
    }

    public function Update(Request $request) {
        $validarot = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'tel' => 'required|string|max:255',
            'address' => 'required|string',
        ]);
        if ($validarot->fails()) {
            return response()->json([
                'errors' => $validarot->messages()
            ]);
        }
        Contact::UpdateItem($request->email, $request->tel, $request->address);
        return response()->json([
            'status' => 'success'
        ]);
    }
}