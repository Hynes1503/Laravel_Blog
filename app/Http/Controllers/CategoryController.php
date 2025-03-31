<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;

class CategoryController extends Controller
{
    public function index($id)
    {
        $category = Category::find($id);

        $blogs = Blog::where('category_id', $id)->paginate(9);

        return view('category.index', compact('category', 'blogs'));
    }
}
