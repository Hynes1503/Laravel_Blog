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
        $blog = $request->route('blog');

        if (!$blog) {
            return redirect()->back()->with('error', 'Bài viết không tồn tại!');
        }

        if (Auth::id() !== $blog->user_id) {
            return redirect()->back()->with('error', 'Hành động không được phép!');
        }

        return $next($request);
    }
}
