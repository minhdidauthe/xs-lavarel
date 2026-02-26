@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Bài viết</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_posts'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-newspaper text-blue-600"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-400">{{ $stats['published_posts'] }} đã đăng, {{ $stats['draft_posts'] }} nháp</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Trang</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pages'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Bình luận</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_comments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-comments text-yellow-600"></i>
                </div>
            </div>
            @if($stats['pending_comments'] > 0)
                <p class="mt-2 text-xs text-red-500 font-bold">{{ $stats['pending_comments'] }} chờ duyệt</p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Lượt xem</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_views']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-eye text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Two Column --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Posts --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800">Bài viết gần đây</h3>
                <a href="{{ route('admin.posts.create') }}" class="text-xs text-red-500 hover:text-red-700 font-bold">+ Thêm mới</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentPosts as $post)
                    <div class="p-4 flex items-center gap-3">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm font-medium text-gray-800 hover:text-red-500 truncate block">{{ $post->title }}</a>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $post->author->name ?? 'N/A' }}
                                &middot; {{ $post->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full
                            {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $post->status === 'published' ? 'Đã đăng' : 'Nháp' }}
                        </span>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-400 text-center">Chưa có bài viết nào</p>
                @endforelse
            </div>
        </div>

        {{-- Pending Comments --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800">Bình luận chờ duyệt</h3>
                <a href="{{ route('admin.comments.index') }}" class="text-xs text-red-500 hover:text-red-700 font-bold">Xem tất cả</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pendingComments as $comment)
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm font-medium text-gray-800">{{ $comment->author_name }}</span>
                            <span class="text-xs text-gray-400">&middot; {{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">{{ $comment->content }}</p>
                        <a href="{{ route('admin.posts.edit', $comment->post_id) }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">
                            {{ $comment->post->title ?? 'N/A' }}
                        </a>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-400 text-center">Không có bình luận chờ duyệt</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
