<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function index()
    {
        $blogs = Blog::where("status", "public")
            ->orderBy("id", "DESC")
            ->paginate(9);

        return view('discover.index', ["blogs" => $blogs]);
    }
}
