<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('education');

        if ($request->has('table_search')) {
            $search = $request->input('table_search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $users = $query->get();
        $education = Education::all(); 

        return view('admin.user.users', [
            'page' => 'Users',
            'data' => $users,
            'education' => $education, 
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'education_id' => 'required', 
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        $hash = Hash::make($request->password);

        $role = $request->filled('role') ? $request->role : 'user';
        $created_by = Auth::id();
        $updated_by = Auth::id();

        $user = User::create([
            'education_id' => $request->education_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hash,
            'role' => $role,
            'created_by' => $created_by,
            'updated_by' => $updated_by
        ]);

        return redirect('/admin/users')->with('register_success', 'Registration Successful!');
    }

    public function show(string $id)
    {
        $user = User::with('education')->findOrFail($id);
        $education = Education::latest()->get();
        return view('admin.user.edit_user', [
            'page' => 'Edit User',
            'data' => [$user],
            'education' => $education,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'education_id' => 'required', 
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        $hash = Hash::make($request->password);

        $user = User::findOrFail($id);
        $updated_by = Auth::id();

        $user->update([
            'education_id' => $request->education_id,
            'email' => $request->email,
            'updated_by' => $updated_by,
            'password' => $hash
        ]);

        return redirect('/admin/users')->with('update_success', 'User Successfully Updated!');
    }

    public function destroy(string $id)
    {
        $whodelete = Auth::id();
        $dumpemail = Str::upper(Str::random(16));

        $user = User::findOrFail($id);
        $user->update([
            'email' => $dumpemail,
            'updated_by' => $whodelete
        ]);
        $user->delete();

        return redirect('/admin/users')->with('delete_success', 'User Successfully Deleted!');
    }

    /**
     * Show the form for editing the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return response()->view('admin.edit-profile');
    }

    public function editProfile(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password' => 'min:8'
        ]);

        if($request->password){
            $newPass = Hash::make($request->password);
        }else {
            $newPass = $request->old_password;
        }

        if($request->hasFile('profile_picture')){
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }else {
            $imageUrl = $user->image;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imageUrl,
            'password' => $newPass
        ]);

        return redirect('/admin/profile')->with('update_success', 'User Successfully Deleted!');
    }
}
