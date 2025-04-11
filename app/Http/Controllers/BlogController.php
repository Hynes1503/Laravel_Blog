<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\User;
use App\Notifications\BlogReported;

class BlogController extends Controller
{

    public function index_dashboard()
    {
        $categories = Category::all();

        $blogs = Blog::whereIn('status', ['public'])
            ->paginate(6);

        $recentBlogs = Blog::whereIn('status', ['public'])
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();

        $topFavoritedBlogs = Blog::whereIn('status', ['public'])
            ->withCount('favoritedByUsers')
            ->orderByDesc('favorited_by_users_count')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('dashboard', compact('blogs', 'topFavoritedBlogs', 'recentBlogs', 'categories'));
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
            "category_id" => "required|exists:categories,id" // Đảm bảo category_id tồn tại
        ]);

        $data["user_id"] = $request->user()->id;

        if ($request->hasFile("banner_image")) {
            $data["banner_image"] = $request->file("banner_image")->store("blog", "public");
        }

        Blog::create($data);

        return to_route('blog.index')->with("success", "Blog created successfully");
    }


    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load('category'); // Nạp quan hệ category
        session(['blog_view_start_time_' . $blog->id => now()->timestamp]);
        return view('blog.show', [
            "blog" => $blog,
            "category" => $blog->category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('blog.edit', compact('blog', 'categories'));
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
            "category_id" => "required|exists:categories,id",
        ]);

        if ($request->hasFile("banner_image")) {
            if ($blog->banner_image) {
                Storage::disk("public")->delete($blog->banner_image);
            }
            $data["banner_image"] = $request->file("banner_image")->store("blogs", "public");
        }

        if (!$blog->reported && $data['reported']) {

            $blog->user->notify(new BlogReported($blog));

            User::where('is_admin', true)->get()->each->notify(new BlogReported($blog));
        }

        $blog->update($data);

        return to_route("blog.show", $blog)->with("success", "Cập nhật thành công.");
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

    public function trackViewTime(Request $request, Blog $blog)
    {
        $startTime = session('blog_view_start_time_' . $blog->id);
        if ($startTime) {
            $endTime = now()->timestamp;
            $timeSpent = $endTime - $startTime; 

            $blog->increment('view_time', $timeSpent);

            $request->session()->forget('blog_view_start_time_' . $blog->id);
        }

        return response()->json(['success' => true]);
    }

    public function report(Request $request, Blog $blog)
    {
        if (!$blog->reported) {
            $blog->update(['reported' => true]);

            $blog->user->notify(new BlogReported($blog));

            $admins = User::where('is_admin', true)->get();
            foreach ($admins as $admin) {
                $admin->notify(new BlogReported($blog));
            }

            return redirect()->back()->with('success', 'Blog has been reported successfully!');
        }

        return redirect()->back()->with('error', 'This blog has already been reported!');
    }
}
