<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with('author', 'category', 'tags')
            ->latest('published_at')
            ->paginate(12);

        $featured = Post::published()->featured()
            ->latest('published_at')->limit(3)->get();

        $categories = Category::where('is_active', true)
            ->withCount(['posts' => fn($q) => $q->published()])
            ->get();

        $tags = Tag::withCount(['posts' => fn($q) => $q->published()])
            ->orderByDesc('posts_count')->limit(20)->get();

        return view('blog.index', compact('posts', 'featured', 'categories', 'tags'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->published()
            ->with('author', 'category', 'tags')
            ->firstOrFail();

        $post->incrementViewCount();

        $renderedContent = $post->getRenderedBody();

        $comments = $post->comments()->approved()
            ->whereNull('parent_id')
            ->with('replies', 'user')
            ->latest()->get();

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->limit(4)->latest()->get();

        return view('blog.show', compact('post', 'renderedContent', 'comments', 'related'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $posts = Post::published()->byCategory($category->id)
            ->with('author', 'tags')
            ->latest('published_at')->paginate(12);

        return view('blog.category', compact('category', 'posts'));
    }

    public function tag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()->published()
            ->with('author', 'category')
            ->latest('published_at')->paginate(12);

        return view('blog.tag', compact('tag', 'posts'));
    }

    public function storeComment(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->published()->firstOrFail();

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'guest_name' => 'required_without:user_id|string|max:100',
            'guest_email' => 'required_without:user_id|email|max:150',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'guest_name' => auth()->check() ? null : $validated['guest_name'],
            'guest_email' => auth()->check() ? null : $validated['guest_email'],
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Bình luận của bạn đang chờ duyệt.');
    }
}
