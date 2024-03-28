<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'education' => 'required'
        ]);

        $created_by = Auth::user()->id;

        $education = Education::create([
            'education' => $request->education,
            'created_by' => $created_by,
            'updated_by' => $created_by
        ]);

        return redirect('/admin/education')->with('education_success', 'Education Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'education' => 'required'
        ]);

        $category = Education::where('id', $id);
        $updated_by = Auth::user()->id;

        $category->update([
            'education' => $request->education,
            'updated_by' => $updated_by
        ]);

        return redirect('/admin/education')->with('education_success', 'Education Berhasil Diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $education = Education::where('id', $id);
        $education->delete();

        return redirect('/admin/education')->with('delete_success', 'Education Berhasil Di Hapus!');
    }
}
