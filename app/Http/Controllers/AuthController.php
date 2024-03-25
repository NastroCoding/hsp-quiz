<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'password' => 'required|min:8'
        ]);

        $credentials = [
            'name' => $request->name,
            'password' => $request->password,
        ];

        $user = User::where('name', $request->name)->first();
        if(Auth::attempt($credentials)){
            if($user->role == 'admin'){
                return redirect('admin.dashboard');
            }else{
                return redirect('user.dashboard');
            }
        }else{
            return back()->withErrors('Invalid Credentials');
        }
    }
}
