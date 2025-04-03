<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;

class AuthorController extends Controller
{
    public function index($user_id)
    {
        $author = User::findOrFail($user_id);
        $blogs = Blog::where("user_id", $user_id)
            ->where("status", "public")
            ->orderby("id", "DESC")
            ->paginate(9);
        return view('author.index', [
            "blogs" => $blogs,
            "author" => $author
        ]);
    }
}
