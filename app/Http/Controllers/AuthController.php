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
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = User::where('email', $request->email)->first();
        if(Auth::attempt($credentials)){
            if($user->role == 'admin' || $user->role == 'superadmin'){
                return redirect('/admin/dashboard');
            }else{
                return redirect('/home');
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

        $user = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => $hash,
            'role' => $default_role,
        ]);

        return redirect('/')->with('register_success', 'Registrasi Berhasil!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('logout_success', 'Logout Successful!');
    }
}
