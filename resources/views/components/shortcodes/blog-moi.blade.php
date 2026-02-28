@if($posts->count() > 0)
<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-newspaper"></i> Kinh Nghiệm Lô Đề - Bài Viết Mới</h2>
    <div class="sc-blog-grid">
        @foreach($posts as $post)
        <a href="/blog/{{ $post->slug }}" class="sc-blog-card">
            @if($post->featured_image)
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="sc-blog-img">
            @else
                <div class="sc-blog-img-placeholder"><i class="fas fa-image"></i></div>
            @endif
            <div class="sc-blog-info">
                @if($post->category)
                    <span class="sc-blog-cat">{{ $post->category->name }}</span>
                @endif
                <h3>{{ $post->title }}</h3>
                <p>{{ Str::limit($post->excerpt ?? strip_tags($post->content), 80) }}</p>
                <span class="sc-blog-date"><i class="fas fa-clock"></i> {{ $post->published_at?->format('d/m/Y') }}</span>
            </div>
        </a>
        @endforeach
    </div>
    <div style="text-align:center; margin-top:16px;">
        <a href="/blog" class="sc-btn-more">Xem tất cả bài viết <i class="fas fa-arrow-right"></i></a>
    </div>
</section>
@endif
