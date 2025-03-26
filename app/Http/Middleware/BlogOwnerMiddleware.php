<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogOwnerMiddleware
{
    /**
     * Xử lý một yêu cầu đến.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy ID blog từ tham số route
        $blogId = $request->route('blog');

        // Tìm blog theo ID
        $blog = Blog::find($blogId);

        // Nếu blog không tồn tại
        if (!$blog) {
            return redirect()->back()->with('error', 'Bài viết không tồn tại!');
        }

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thực hiện hành động này!');
        }

        // Kiểm tra quyền sở hữu
        if (Auth::id() !== $blog->user_id) {
            return redirect()->back()->with('error', 'Hành động không được phép!');
        }

        // Nếu hợp lệ, tiếp tục xử lý request
        return $next($request);
    }
}