<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Blog;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
    public function store(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['blog_id'] = $blog->id;

        $comment = Comment::create($data);

        if ($blog->user_id !== $request->user()->id) {
            $blog->user->notify(new NewCommentNotification($comment));
        }

        return back()->with('success', 'Bình luận đã được thêm thành công.');
    }

    /**
     * Cập nhật bình luận
     */
    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($data);

        return back()->with('success', 'Bình luận đã được cập nhật.');
    }

    /**
     * Xóa bình luận
     */
    public function destroy(Request $request, Comment $comment)
    {
        if ($comment->user_id !== $request->user()->id && $request->user()->is_admin !== 1) {
            return back()->with('error', 'Bạn không có quyền xóa bình luận này.');
        }

        $comment->delete();

        return back()->with('success', 'Bình luận đã được xóa.');
    }
}
