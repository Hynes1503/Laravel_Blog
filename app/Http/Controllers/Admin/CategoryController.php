<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only(['name', 'slug', 'description']));

        return redirect()->route('categories.index')->with('success', 'Create successful');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Tìm category theo slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Lấy danh sách blog thuộc category đó
        $blogs = $category->blogs()->where('status', 'public')->latest()->paginate(10);

        // Trả về view hiển thị danh sách blog
        return view('categories.show', compact('category', 'blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->only(['name', 'slug', 'description']));

        return redirect()->route('categories.index')->with('success', 'Update Successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Delete successful!');
    }
}
