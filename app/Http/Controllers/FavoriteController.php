<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class FavoriteController extends Controller
{
    public function toggleFavorite(Blog $blog)
    {
        $favoriteCount = $blog->favoritesCount();
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện thao tác này'], 401);
        }

        $user = Auth::user();

        if ($blog->favoritedByUsers()->where('user_id', $user->id)->exists()) {
            $blog->favoritedByUsers()->detach($user->id);
            return redirect()->route('blog.show', $blog->id)->with('success', 'Đã bỏ yêu thích');
        } else {
            $blog->favoritedByUsers()->attach($user->id);
            return redirect()->route('blog.show', $blog->id)->with('success', 'Đã thêm vào yêu thích');
        }
    }
}
