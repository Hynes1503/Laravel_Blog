<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $blogs = Blog::orderBy('id', 'DESC')->paginate(10);
            $totalBlogs = Blog::countAllBlogs(); // Gọi hàm đếm tổng số blog

            return view('admin.blog.index', compact('blogs', 'totalBlogs'));
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi tải danh sách blog: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|string|max:50",
            "description" => "nullable|string",
            "banner_image" => "required|image",
            "status" => "required|in:public,private",
            "category_ids" => "required|array", 
            "category_ids.*" => "exists:categories,id" 
        ]);

        $data["user_id"] = $request->user()->id;

        if ($request->hasFile("banner_image")) {
            $data["banner_image"] = $request->file("banner_image")->store("blog", "public");
        }


        $blog = Blog::create($data);

        $blog->categories()->attach($data["category_ids"]);

        return to_route('blog.index')->with("success", "Blog created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('admin.blog.show', ["blog" => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', ["blog" => $blog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "status" => "required|in:public,private",
            "reported" => "nullable|boolean" 
        ]);

        if ($request->hasFile("banner_image")) {
            if ($blog->banner_image) {
                Storage::disk("public")->delete($blog->banner_image);
            }
            $data["banner_image"] = $request->file("banner_image")->store("blogs", "public");
        }

        $blog->update($data);

        return to_route("admin.blog.show", $blog)->with("success", "Update successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->banner_image) {
            Storage::disk("public")->delete($blog->banner_image);
        }
        $blog->delete();
        return to_route('admin.blog.index')->with("success", "deleted successfully");
    }
}
