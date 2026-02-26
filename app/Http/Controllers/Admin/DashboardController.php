<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_pages' => Page::count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'total_views' => Post::sum('view_count'),
        ];

        $recentPosts = Post::with('author', 'category')
            ->latest()->limit(5)->get();

        $pendingComments = Comment::with('post', 'user')
            ->where('status', 'pending')
            ->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'pendingComments'));
    }
}
