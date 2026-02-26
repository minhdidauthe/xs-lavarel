@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title . ' - SOICAU7777.CLICK')

@section('styles')
<style>
    .prose { line-height: 1.8; }
    .prose h2 { font-size: 1.25rem; font-weight: 800; color: white; margin-top: 2rem; margin-bottom: 1rem; }
    .prose h3 { font-size: 1.1rem; font-weight: 700; color: white; margin-top: 1.5rem; margin-bottom: 0.75rem; }
    .prose p { margin-bottom: 1rem; color: #9ca3af; font-size: 0.9rem; }
    .prose a { color: #ef4444; text-decoration: underline; }
    .prose img { border-radius: 1rem; margin: 1.5rem 0; }
    .prose ul, .prose ol { margin-bottom: 1rem; padding-left: 1.5rem; color: #9ca3af; font-size: 0.9rem; }
    .prose ul { list-style: disc; }
    .prose ol { list-style: decimal; }
    .prose li { margin-bottom: 0.25rem; }
    .prose blockquote { border-left: 3px solid #ef4444; padding-left: 1rem; color: #6b7280; font-style: italic; margin: 1.5rem 0; }
    .prose table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
    .prose table th, .prose table td { border: 1px solid rgba(255,255,255,0.1); padding: 0.5rem; font-size: 0.85rem; }
    .prose table th { background: rgba(255,255,255,0.05); color: white; font-weight: 700; }
    .prose code { background: rgba(255,255,255,0.05); padding: 0.15rem 0.4rem; border-radius: 0.25rem; font-size: 0.85em; color: #f87171; }
    .prose pre { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 0.75rem; padding: 1rem; overflow-x: auto; margin: 1rem 0; }
    .prose pre code { background: none; padding: 0; color: #d1d5db; }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-3">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-[10px] text-gray-600 mb-6 font-medium uppercase tracking-wider">
                <a href="{{ route('blog.index') }}" class="hover:text-white transition">Blog</a>
                <i class="fas fa-chevron-right text-[8px]"></i>
                @if($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-white transition">{{ $post->category->name }}</a>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                @endif
                <span class="text-gray-500 truncate max-w-xs">{{ $post->title }}</span>
            </nav>

            {{-- Article --}}
            <article class="glass-card rounded-2xl overflow-hidden">
                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                         class="w-full h-64 md:h-80 object-cover">
                @endif

                <div class="p-6 md:p-8">
                    {{-- Meta --}}
                    <div class="flex items-center gap-4 mb-4 text-[10px] text-gray-600 uppercase tracking-wider">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-red-500 font-bold">{{ $post->category->name }}</a>
                        @endif
                        <span><i class="fas fa-clock mr-1"></i>{{ $post->published_at?->format('d/m/Y') }}</span>
                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }} lượt xem</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-2xl md:text-3xl font-black text-white leading-tight mb-4">{{ $post->title }}</h1>

                    {{-- Author --}}
                    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-white/5">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($post->author->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">{{ $post->author->name ?? 'Admin' }}</p>
                            <p class="text-[10px] text-gray-600">{{ $post->published_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Content with rendered shortcodes --}}
                    <div class="prose">
                        {!! $renderedContent !!}
                    </div>

                    {{-- Tags --}}
                    @if($post->tags->count())
                        <div class="flex flex-wrap gap-2 mt-8 pt-6 border-t border-white/5">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}"
                                   class="text-[10px] bg-white/5 text-gray-400 px-3 py-1.5 rounded-full hover:bg-red-500/20 hover:text-red-400 transition font-medium">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>

            {{-- Comments Section --}}
            <div class="mt-8 glass-card rounded-2xl p-6 md:p-8">
                <h2 class="text-lg font-black text-white mb-6">
                    <i class="fas fa-comments text-red-500 mr-2"></i>Bình luận ({{ $comments->count() }})
                </h2>

                {{-- Comment Form --}}
                <form action="{{ route('blog.comment', $post->slug) }}" method="POST" class="mb-8">
                    @csrf
                    @if(session('success'))
                        <div class="bg-green-500/10 border border-green-500/20 text-green-400 text-xs rounded-lg p-3 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @guest
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="guest_name" placeholder="Tên của bạn *" required
                                   value="{{ old('guest_name') }}"
                                   class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50">
                            <input type="email" name="guest_email" placeholder="Email *" required
                                   value="{{ old('guest_email') }}"
                                   class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50">
                        </div>
                    @endguest

                    <textarea name="content" rows="4" placeholder="Viết bình luận..." required
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 mb-4">{{ old('content') }}</textarea>

                    @error('content')
                        <p class="text-xs text-red-500 mb-2">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="gradient-brand text-white font-bold py-2.5 px-6 rounded-xl text-sm hover:shadow-lg hover:shadow-red-600/20 transition">
                        <i class="fas fa-paper-plane mr-2"></i>Gửi bình luận
                    </button>
                </form>

                {{-- Comments List --}}
                <div class="space-y-6">
                    @forelse($comments as $comment)
                        <div class="border-b border-white/5 pb-6 last:border-0">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-bold text-gray-400">
                                    {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-white">{{ $comment->author_name }}</span>
                                    <span class="text-[10px] text-gray-600 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 pl-11">{!! nl2br(e($comment->content)) !!}</p>

                            {{-- Replies --}}
                            @if($comment->replies->count())
                                <div class="ml-11 mt-4 space-y-4 border-l-2 border-white/5 pl-4">
                                    @foreach($comment->replies as $reply)
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-xs font-bold text-white">{{ $reply->author_name }}</span>
                                                <span class="text-[10px] text-gray-600">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs text-gray-500">{!! nl2br(e($reply->content)) !!}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-600 text-sm py-4">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                    @endforelse
                </div>
            </div>

            {{-- Related Posts --}}
            @if($related->count())
                <div class="mt-8">
                    <h2 class="text-lg font-black text-white mb-4">
                        <i class="fas fa-link text-orange-500 mr-2"></i>Bài viết liên quan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($related as $relPost)
                            <a href="{{ route('blog.show', $relPost->slug) }}" class="glass-card rounded-xl overflow-hidden group flex">
                                @if($relPost->featured_image)
                                    <img src="{{ Storage::url($relPost->featured_image) }}" alt="{{ $relPost->title }}"
                                         class="w-24 h-24 object-cover flex-shrink-0">
                                @else
                                    <div class="w-24 h-24 bg-white/5 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-newspaper text-gray-700"></i>
                                    </div>
                                @endif
                                <div class="p-3 flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-white group-hover:text-red-400 transition line-clamp-2">{{ $relPost->title }}</h4>
                                    <p class="text-[10px] text-gray-600 mt-1">{{ $relPost->published_at?->format('d/m/Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Table of Contents placeholder --}}
            <div class="glass-card rounded-2xl p-5">
                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-4">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>Thông tin
                </h3>
                <div class="space-y-3 text-xs text-gray-500">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user w-4 text-gray-600"></i>
                        <span>{{ $post->author->name ?? 'Admin' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar w-4 text-gray-600"></i>
                        <span>{{ $post->published_at?->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-eye w-4 text-gray-600"></i>
                        <span>{{ number_format($post->view_count) }} lượt xem</span>
                    </div>
                    @if($post->category)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-folder w-4 text-gray-600"></i>
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-red-500 hover:underline">{{ $post->category->name }}</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Share --}}
            <div class="glass-card rounded-2xl p-5">
                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-4">
                    <i class="fas fa-share-alt text-green-500 mr-2"></i>Chia sẻ
                </h3>
                <div class="flex gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                       class="w-10 h-10 bg-blue-600/20 text-blue-400 rounded-xl flex items-center justify-center hover:bg-blue-600/30 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank"
                       class="w-10 h-10 bg-sky-500/20 text-sky-400 rounded-xl flex items-center justify-center hover:bg-sky-500/30 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank"
                       class="w-10 h-10 bg-cyan-500/20 text-cyan-400 rounded-xl flex items-center justify-center hover:bg-cyan-500/30 transition">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
