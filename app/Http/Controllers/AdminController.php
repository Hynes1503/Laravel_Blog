<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class AdminController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy("id", "DESC")->paginate(9);
        return view('admin.index', ["blogs" => $blogs]);
    }
}
