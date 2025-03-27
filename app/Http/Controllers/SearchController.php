<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm blog theo tiêu đề hoặc mô tả
        $blogs = Blog::where('status', 'public') // Lọc bài viết có status là 'public'
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->paginate(9); // Phân trang

        return view('discover.index', ["blogs" => $blogs]);
    }

    public function admin_index(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm blog theo tiêu đề hoặc mô tả
        $blogs = Blog::where('status', 'public') // Lọc bài viết có status là 'public'
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->paginate(9); // Phân trang

        return view('admin.blog.index', ["blogs" => $blogs]);
    }
}
