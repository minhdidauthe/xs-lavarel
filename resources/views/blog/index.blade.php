@extends('layouts.app')

@section('title', 'Blog - SOICAU7777.CLICK')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-3xl font-black text-white uppercase tracking-tight">
            <i class="fas fa-newspaper text-red-500 mr-2"></i>Blog
        </h1>
        <p class="text-sm text-gray-500 mt-2">Tin tức, phân tích và kiến thức xổ số</p>
    </div>

    {{-- Featured Posts --}}
    @if($featured->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($featured as $idx => $post)
                <a href="{{ route('blog.show', $post->slug) }}"
                   class="glass-card rounded-2xl overflow-hidden group {{ $idx === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                    @if($post->featured_image)
                        <div class="overflow-hidden {{ $idx === 0 ? 'h-64 md:h-full' : 'h-48' }}">
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @else
                        <div class="flex items-center justify-center {{ $idx === 0 ? 'h-64 md:h-80' : 'h-48' }} bg-gradient-to-br from-red-600/20 to-orange-600/20">
                            <i class="fas fa-newspaper text-4xl text-gray-600"></i>
                        </div>
                    @endif
                    <div class="p-5">
                        @if($post->category)
                            <span class="text-[10px] font-bold uppercase text-red-500 tracking-widest">{{ $post->category->name }}</span>
                        @endif
                        <h2 class="text-lg font-black text-white mt-1 group-hover:text-red-400 transition-colors line-clamp-2">{{ $post->title }}</h2>
                        @if($post->excerpt)
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                        @endif
                        <div class="flex items-center gap-3 mt-3 text-[10px] text-gray-600">
                            <span><i class="fas fa-user mr-1"></i>{{ $post->author->name ?? 'Admin' }}</span>
                            <span><i class="fas fa-clock mr-1"></i>{{ $post->published_at?->format('d/m/Y') }}</span>
                            <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Main Content - Post Grid --}}
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="glass-card rounded-2xl overflow-hidden group">
                        @if($post->featured_image)
                            <div class="overflow-hidden h-44">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="flex items-center justify-center h-44 bg-gradient-to-br from-white/5 to-white/0">
                                <i class="fas fa-newspaper text-3xl text-gray-700"></i>
                            </div>
                        @endif
                        <div class="p-4">
                            @if($post->category)
                                <span class="text-[10px] font-bold uppercase text-red-500 tracking-widest">{{ $post->category->name }}</span>
                            @endif
                            <h3 class="text-sm font-bold text-white mt-1 group-hover:text-red-400 transition-colors line-clamp-2">{{ $post->title }}</h3>
                            @if($post->excerpt)
                                <p class="text-[11px] text-gray-500 mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-3 text-[10px] text-gray-600">
                                <span><i class="fas fa-clock mr-1"></i>{{ $post->published_at?->format('d/m/Y') }}</span>
                                <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <i class="fas fa-inbox text-4xl text-gray-700 mb-4"></i>
                        <p class="text-gray-500">Chưa có bài viết nào.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Categories --}}
            <div class="glass-card rounded-2xl p-5">
                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-4">
                    <i class="fas fa-folder text-red-500 mr-2"></i>Danh mục
                </h3>
                <div class="space-y-2">
                    @foreach($categories as $category)
                        <a href="{{ route('blog.category', $category->slug) }}"
                           class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-white/5 transition group">
                            <span class="text-xs text-gray-400 group-hover:text-white transition">{{ $category->name }}</span>
                            <span class="text-[10px] bg-white/10 text-gray-500 px-2 py-0.5 rounded-full">{{ $category->posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Tags --}}
            <div class="glass-card rounded-2xl p-5">
                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-4">
                    <i class="fas fa-tags text-orange-500 mr-2"></i>Tags
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}"
                           class="text-[10px] bg-white/5 text-gray-400 px-3 py-1.5 rounded-full hover:bg-red-500/20 hover:text-red-400 transition font-medium">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
