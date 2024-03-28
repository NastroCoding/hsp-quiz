<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return view('admin.category.category', ['data' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_name' => 'required',
        ]);

        $created_by = Auth::user()->id;

        $category = Category::create([
            'category_name' => $request->category_name,
            'created_by' => $created_by,
            'updated_by' => $created_by
        ]);

        return redirect('/admin/category')->with('category_create', 'Kategori Berhasil Ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'category_name' => 'required'
        ]);

        $category = Category::where('id', $id);
        $updated_by = Auth::user()->id;

        $category->update([
            'category_name' => $request->category_name,
            'updated_by' => $updated_by
        ]);

        return redirect('/admin/category')->with('category_success', 'Kategori Berhasil Diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Category::where('id', $id);
        $user->delete();

        return redirect('/admin/category')->with('delete_success', 'Kategori Berhasil Di Hapus!');
    }
}
