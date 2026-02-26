@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title . ' - SOICAU7777.CLICK')

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
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    {{-- Page Content --}}
    <article class="glass-card rounded-2xl overflow-hidden">
        <div class="p-6 md:p-10">
            <h1 class="text-2xl md:text-3xl font-black text-white leading-tight mb-8">{{ $page->title }}</h1>

            <div class="prose">
                {!! $renderedContent !!}
            </div>
        </div>
    </article>
</div>
@endsection
