<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Blog;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        $reportedFilter = $request->input('reported_filter');

        $commentsQuery = Comment::with('user', 'blog');

        // Tìm kiếm theo nội dung bình luận nếu có query
        if ($query) {
            $commentsQuery->where('content', 'like', "%{$query}%");
        }

        // Lọc theo trạng thái reported
        if ($reportedFilter === 'reported') {
            $commentsQuery->where('reported', true);
        }

        $comments = $commentsQuery->paginate(10); // Phân trang 10 bình luận mỗi trang

        return view('admin.comment.index', compact('comments'));
    }

    public function store(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['blog_id'] = $blog->id;

        $comment = Comment::create($data);

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

    public function report(Request $request, Comment $comment)
    {

        $comment->update(['reported' => true]);

        return redirect()->back()->with('success', 'Comment has been reported successfully!');
    }

}
