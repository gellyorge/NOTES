<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginSubmit(Request $request){
        //form validation
        $request->validate(
            // rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            // error messages
            [
                'text_username.required' => 'O username e obrigatorio',
                'text_username.email' => 'O username deve ser um email valido',
                'text_password.required' => 'A password e obrigatorio',
                'text_password.min' => 'A password deve ter no minimo :min caracteres',
                'text_password.max' => 'A password deve ter no maximo :max caracteres'
            ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');

       //check if user exists
        $user = User::where('username', $username)
            ->where('deleted_at',null)
            ->first();

        if(!$user){
            return redirect()
            ->back()
            ->withInput()
            ->with('loginError', 'Username ou password incorretos.');
        }
        //check if password is correct
        if(!password_verify($password, $user->password)){
            return redirect()
            ->back()
            ->withInput()
            ->with('loginError', 'Username ou password incorretos.');
        }
        //update last_login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session([
            'user'=> [
                'id' => $user->id,
                'username' => $user->username,
            ]
            ]);
        //ridirect home
        return redirect()->to('/');
    }

    public function logout(){
        //logout from the application
        session()->forget('user');
        return redirect()->to('login');
    }


}
