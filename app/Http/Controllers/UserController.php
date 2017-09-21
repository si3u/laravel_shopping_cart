<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\EditPasswordRequest;
use App\Http\Requests\User\SignInRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @param SignInRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function SignIn(SignInRequest $request) {
        if (Auth::attempt(['login'=> $request->login, 'password'=>$request->password], true)) {
            return redirect()->route('admin/main');
        }
        else {
            return redirect()->back()->withErrors(['errors' => 'Неверный логин или пароль.']);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function SignOut() {
        Auth::logout();
        return redirect()->route('admin/login');
    }

    /**
     * @param EditPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ChangePass(EditPasswordRequest $request) {
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
        $new_pass = Hash::make($request->new_pass1);
        $user = Auth::User();
        $user->password = $new_pass;
        if ($user->save()) {
            return response()->json([
                'status' => 'true'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }

    public function ChangeEmail(ChangeEmailRequest $request) {
        $user = Auth::user();
        $user->email = $request->email;
        if ($user->save()) {
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}
