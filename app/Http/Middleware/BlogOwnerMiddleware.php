<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogOwnerMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $blog = $request->route('blog');
        $user = Auth::user();

        if (!$blog) {
            return redirect()->back()->with('error', 'This Blog does not exist');
        }

        if ($user->is_admin !== 1 && $user->id !== $blog->user_id) {
            return redirect()->back()->with('error', 'Not authorized!');
        }

        return $next($request);
    }
}
