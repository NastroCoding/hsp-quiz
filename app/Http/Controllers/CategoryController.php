<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('table_search')) {
            $search = $request->input('table_search');
            $query->where('category_name', 'like', '%' . $search . '%');
        }

        $categories = $query->get();

        return view('admin.category.category', [
            'data' => $categories,
            'page' => 'Categories'
        ]);
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
        $slug = Str::slug($request->category_name);

        $category = Category::create([
            'category_name' => $request->category_name,
            'created_by' => $created_by,
            'updated_by' => $created_by,
            'slug' => $slug
        ]);

        return redirect('/admin/category')->with('category_create', 'Category Berhasil Ditambahkan!');
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

        return redirect('/admin/category')->with('category_success', 'Category Berhasil Diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::where('id', $id);
        $category->delete();

        return redirect('/admin/category')->with('delete_success', 'Category Berhasil Di Hapus!');
    }
}
