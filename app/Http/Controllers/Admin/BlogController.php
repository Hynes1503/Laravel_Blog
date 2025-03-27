<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->paginate(10);
        return view('admin.blog.index', ['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
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
            "status" => "required|in:public,private"
        ]);

        // Gán user_id từ người dùng đăng nhập
        $data["user_id"] = $request->user()->id;

        // Xử lý upload hình ảnh
        if ($request->hasFile("banner_image")) {
            $data["banner_image"] = $request->file("banner_image")->store("blog", "public");
        }

        // Lưu vào database
        Blog::create($data);

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
            "status" => "required|in:public,private"
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
