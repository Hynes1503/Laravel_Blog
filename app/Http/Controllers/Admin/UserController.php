<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('is_admin', 0)->latest()->paginate(10);
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

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'email.unique' => 'Email này đã được sử dụng.',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User added successfully');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'reported' => 'required|boolean' // Thêm trường reported
        ]);

        // Nếu không có password mới, loại bỏ khỏi $data
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return back()->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        try {
            // Tìm user theo id
            $user = User::findOrFail($id);

            // Không cho phép xóa admin
            if ($user->is_admin) {
                return redirect()->back()->with('error', 'Can not delete admin account');
            }

            // Xóa tất cả blog của user
            $user->blogs()->delete();

            // Xóa user
            $user->delete();

            return redirect()->back()->with('success', 'Delete successful');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function report(Request $request, User $user)
    {
        $user->update(['reported' => true]);

        return redirect()->back()->with('success', 'User has been reported successfully!');
    }
}
