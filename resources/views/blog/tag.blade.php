@extends('layouts.app')

@section('title', '#' . $tag->name . ' - Blog - SOICAU7777.CLICK')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    {{-- Header --}}
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-[10px] text-gray-600 mb-4 font-medium uppercase tracking-wider">
            <a href="{{ route('blog.index') }}" class="hover:text-white transition">Blog</a>
            <i class="fas fa-chevron-right text-[8px]"></i>
            <span class="text-gray-500">Tag: {{ $tag->name }}</span>
        </nav>
        <h1 class="text-2xl font-black text-white tracking-tight">
            <i class="fas fa-tag text-orange-500 mr-2"></i>#{{ $tag->name }}
        </h1>
    </div>

    {{-- Posts Grid --}}
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
                        <span><i class="fas fa-user mr-1"></i>{{ $post->author->name ?? 'Admin' }}</span>
                        <span><i class="fas fa-clock mr-1"></i>{{ $post->published_at?->format('d/m/Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-20">
                <i class="fas fa-inbox text-4xl text-gray-700 mb-4"></i>
                <p class="text-gray-500">Chưa có bài viết nào với tag này.</p>
                <a href="{{ route('blog.index') }}" class="text-red-500 text-sm hover:underline mt-2 inline-block">Quay lại Blog</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection
