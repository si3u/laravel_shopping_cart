<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function SignIn (Request $request) {
        $validator = Validator::make($request->all(), [
            'login' => 'required|min:2|max:16|alpha_dash',
            'password' => 'required|min:5|max:32|alpha_num',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if (Auth::attempt(['login'=> $request->login, 'password'=>$request->password], true)) {
            return redirect()->route('admin/main');
        }
        else {
            return redirect()->back()->withErrors(['errors' => 'Неверный логин или пароль.']);
        }
    }
    public function SignOut() {
        Auth::logout();
        return redirect()->route('admin/login');
    }
    public function EditPass(Request $request) {
        $validator = Validator::make($request->all(), [
            'now_pass' => 'required|min:5|max:32|alpha_num',
            'new_pass1' => 'required|min:8|max:32|alpha_num',
            'new_pass2' => 'required|min:8|max:32|alpha_num'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        if (!Hash::check($request->now_pass, Auth::User()->password)) {
            return response()->json([
                'error' => 'Вы ввели неверный нынешний пароль.'
            ]);
        }
        if ($request->new_pass1 != $request->new_pass2) {
            return response()->json([
                'error' => 'Значения нового пароля не совпадают.'
            ]);
        }
        else {
            $new_pass = Hash::make($request->new_pass1);
            $user = Auth::User();
            $user->password = $new_pass;
            if ($user->save()) {
                return response()->json([
                    'status' => 'true'
                ]);
            }
        }
    }
}
