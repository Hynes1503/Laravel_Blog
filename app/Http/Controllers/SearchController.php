<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Category;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');


        $blogs = Blog::where('status', 'public') 
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->paginate(9); // Phân trang

        return view('discover.index', ["blogs" => $blogs]);
    }

    public function admin_blog_index(Request $request)
    {
        $query = $request->input('query');
        $reportedFilter = $request->input('reported_filter');

        $blogsQuery = Blog::query();


        if ($query) {
            $blogsQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        }


        switch ($reportedFilter) {
            case 'blog':
                $blogsQuery->where('reported', true);
                break;
            case 'user':
                $blogsQuery->whereHas('user', function ($q) {
                    $q->where('reported', true);
                });
                break;
            case 'comment':
                $blogsQuery->whereHas('comments', function ($q) {
                    $q->where('reported', true);
                });
                break;
            default:

                break;
        }

        $blogs = $blogsQuery->with('user', 'comments')->paginate(9);

        return view('admin.blog.index', ['blogs' => $blogs]);
    }

    public function admin_user_index(Request $request)
    {
        $query = $request->input('query');
        $reportedFilter = $request->input('reported_filter');

        $usersQuery = User::query();


        if ($query) {
            $usersQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            });
        }


        if ($reportedFilter === 'reported') {
            $usersQuery->where('reported', true);
        }

        $users = $usersQuery->paginate(10); 

        return view('admin.user.index', ['users' => $users]);
    }
    
    public function admin_category_index(Request $request)
    {
        $query = $request->input('query');

        $categories = Category::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        })
            ->paginate(9);

        return view('admin.categories.index', ['categories' => $categories]);
    }
}
