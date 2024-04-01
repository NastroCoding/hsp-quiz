<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('admin.user.user', [
            'data' => $user,
        ]);
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
        if($request->role == ''){
            $role = 'user';
            $created_by = 'System';
            $updated_by = 'System';
        }else{
            $role = $request->role;
            $created_by = Auth::user()->id;
            $updated_by = Auth::user()->id;
        };


        $user = User::create([
            'email' => $request->email,
            'password' => $hash,
            'role' => $role,
            'token' => $request->token,
            'created_by' => $created_by,
            'updated_by' => $updated_by
        ]);

        return redirect('/admin/users')->with('register_success', 'Registrasi Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = User::where('id', $id)->get();
        $education = Education::latest()->get();
        return view('admin.user.edit_user', [
            'page' => 'Edit User',
            'data' => $show,
            'education' => $education,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'token' => 'required|min:8',
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        $hash = Hash::make($request->password);

        $user = User::where('id', $id);
        $updated_by = Auth::user()->id;

        $user->update([
            'token' => $request->token,
            'email' => $request->email,
            'updated_by' => $updated_by,
            'password' => $request->password
        ]);

        return redirect('/admin/users')->with('update_success', 'User Berhasil di Update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $whodelete = Auth::user()->id;
        $dumpemail = Str::upper(Str::random(16));
        $user = User::where('id', $id);
        $user->update([
            'email' => $dumpemail,
            'updated_by' => $whodelete
        ]);
        $user->delete();

        return redirect('/admin/users')->with('delete_success', 'User Berhasil Di Hapus!');
    }
}
