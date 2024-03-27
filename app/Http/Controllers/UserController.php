<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('admin.user.user', ['data' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'token' => 'required|min:8',
            'password' => 'required|min:8'
        ]);

        $hash = Hash::make($request->password);
        $default_role = "user";

        $user = User::create([
            'email' => $request->email,
            'password' => $hash,
            'role' => $default_role,
            'token' => $request->token
        ]);

        return redirect('/admin/users')->with('register_success', 'Registrasi Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = User::where('id', $id)->get();
        return view('admin.user.edit_user', [
            'page' => 'Edit User',
            'data' => $show,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id);
        $user->delete();

        return redirect('/admin/users')->with('delete_success', 'User Berhasil Di Hapus!');
    }
}
