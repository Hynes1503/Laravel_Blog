<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.user.index', ['users' => $users]);
    }

    public function index_author($user_id)
    {
        $author = User::findOrFail($user_id);
        $blogs = Blog::where("user_id", $user_id)
            ->orderby("id", "DESC")
            ->paginate(9);
        return view('admin.user.show', [
            "blogs" => $blogs,
            "author" => $author
        ]);
    }

    public function edit(User $User)
    {
        return view('admin.user.edit', ["User" => $User]);
    }


    public function destroy($id)
    {
        try {
            // Tìm user theo id
            $user = User::findOrFail($id);

            // Kiểm tra nếu là admin
            if ($user->is_admin) {
                return redirect()->back()->with('error', 'Can not delete admin account');
            }

            // Xóa user
            $user->delete();

            return redirect()->back()->with('success', 'Delete successful');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed');
        }
    }
}
