<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(){
        return view('auth.login');
    }

    public function signin(Request $request){
        $validate = $request->validate([
            'token' => 'required',
            'password' => 'required|min:8'
        ]);

        $credentials = [
            'token' => $request->token,
            'password' => $request->password,
        ];

        $user = User::where('token', $request->token)->first();
        if(Auth::attempt($credentials)){
            if($user->role == 'admin'){
                return view('admin.dashboard');
            }else{
                return view('user.dashboard');
            }
        }else{
            return back()->withErrors('Invalid Credentials');
        }
    }

    public function register(){
        return view('auth.register');
    }

    public function signup(Request $request){
        $validate = $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $hash = Hash::make($request->password);
        $default_role = "user";
        $default_token = "001";

        $user = User::create([
            'email' => $request->email,
            'password' => $hash,
            'role' => $default_role,
            'token' => $default_token
        ]);

        return redirect('/login')->with('register_success', 'Registrasi Berhasil!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('logout_success', 'Logout Successful!');
    }
}
