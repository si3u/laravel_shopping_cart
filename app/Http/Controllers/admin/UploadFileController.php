<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadFileController extends Controller {

    public function Upload(Request $request) {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        $image = $request->file('image');
        $image_name = uniqid('image_').'.'.$image->getClientOriginalExtension();
        $url = 'assets/images/uploads/';
        $image->move($url, $image_name);

        return url(url($url . $image_name));
    }
    
    public function Delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'url' => 'required|string|url'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        $image_name = array();
        preg_match("/&*img_[^\s]*/", $request->url, $image_name);
        File::delete('assets/images/upload/' . $image_name[0]);
    }
}