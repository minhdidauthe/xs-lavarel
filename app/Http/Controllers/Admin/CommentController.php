<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with('post', 'user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $comments = $query->latest()->paginate(20)->withQueryString();

        return view('admin.comments.index', compact('comments'));
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,spam',
        ]);

        $comment->update($validated);

        return back()->with('success', 'Trạng thái bình luận đã được cập nhật.');
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Bình luận đã được duyệt.');
    }

    public function spam(Comment $comment)
    {
        $comment->update(['status' => 'spam']);

        return back()->with('success', 'Bình luận đã được đánh dấu spam.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Bình luận đã được xóa.');
    }
}
