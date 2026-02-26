@extends('layouts.admin')

@section('title', 'Bình luận')
@section('page-title', 'Bình luận')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Bình luận</h2>
            <p class="text-sm text-gray-500 mt-1">Quản lý bình luận bài viết</p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-1 mb-6 bg-white rounded-xl shadow-sm p-1.5">
        <a href="{{ route('admin.comments.index') }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-gradient-to-r from-red-500 to-orange-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
            Tất cả
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'pending' ? 'bg-gradient-to-r from-red-500 to-orange-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
            Chờ duyệt
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'approved' ? 'bg-gradient-to-r from-red-500 to-orange-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
            Đã duyệt
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'spam']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'spam' ? 'bg-gradient-to-r from-red-500 to-orange-500 text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
            Spam
        </a>
    </div>

    {{-- Comments List --}}
    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex items-start justify-between gap-4">
                    {{-- Comment Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-sm font-bold text-gray-800">{{ $comment->author_name }}</span>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>

                            {{-- Status Badge --}}
                            @if($comment->status === 'approved')
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700">Đã duyệt</span>
                            @elseif($comment->status === 'pending')
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-yellow-100 text-yellow-700">Chờ duyệt</span>
                            @elseif($comment->status === 'spam')
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-red-100 text-red-700">Spam</span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($comment->content, 200) }}</p>

                        @if($comment->post)
                            <a href="{{ route('admin.posts.edit', $comment->post_id) }}"
                               class="text-xs text-blue-500 hover:underline">
                                <i class="fas fa-link mr-1"></i>{{ $comment->post->title }}
                            </a>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($comment->status !== 'approved')
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-bold rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors"
                                        title="Duyệt">
                                    <i class="fas fa-check mr-1"></i>Duyệt
                                </button>
                            </form>
                        @endif

                        @if($comment->status !== 'spam')
                            <form action="{{ route('admin.comments.spam', $comment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-bold rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors"
                                        title="Spam">
                                    <i class="fas fa-ban mr-1"></i>Spam
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                              onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 text-xs font-bold rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                    title="Xóa">
                                <i class="fas fa-trash mr-1"></i>Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="text-gray-400">
                    <i class="fas fa-comments text-3xl mb-3"></i>
                    <p class="text-sm">Không có bình luận nào</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($comments->hasPages())
        <div class="mt-6">
            {{ $comments->links() }}
        </div>
    @endif
@endsection
