<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index_dashboard()
    {
        // Lấy 3 bài viết có trạng thái public hoặc must paid, sắp xếp theo ID giảm dần
        $blogs = Blog::whereIn('status', ['public'])
            ->paginate(6);

        // Lấy 3 bài viết mới update có trạng thái public hoặc must paid
        $recentBlogs = Blog::whereIn('status', ['public'])
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();

        // Lấy 3 bài viết có nhiều lượt yêu thích nhất, chỉ lấy bài viết public hoặc must paid
        $topFavoritedBlogs = Blog::whereIn('status', ['public'])
            ->withCount('favoritedByUsers')
            ->orderByDesc('favorited_by_users_count')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('dashboard', compact('blogs', 'topFavoritedBlogs', 'recentBlogs'));
    }

    public function index()
    {
        $blogs = Blog::where("user_id", request()->user()->id)->orderby("id", "DESC")->paginate(9);
        return view('blog.index', ["blogs" => $blogs]);
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
        return view('blog.show', ["blog" => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('blog.edit', ["blog" => $blog]);
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

        return to_route("blog.show", $blog)->with("success", "Update successfully");
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
        return to_route('blog.index')->with("success", "deleted successfully");
    }
}
