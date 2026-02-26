<?php

namespace App\Models;

use App\Services\ShortcodeParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'author_id', 'category_id', 'title', 'slug', 'excerpt', 'content',
        'rendered_content', 'featured_image', 'meta_title', 'meta_description',
        'meta_keywords', 'og_image', 'status', 'is_featured', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'view_count' => 'integer',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published')->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('is_featured', true);
    }

    public function scopeByCategory(Builder $q, int $categoryId): Builder
    {
        return $q->where('category_id', $categoryId);
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function (Post $post) {
            if ($post->isDirty('content')) {
                $post->rendered_content = null;
            }
        });
    }

    public function getRenderedBody(): string
    {
        if ($this->rendered_content) {
            return $this->rendered_content;
        }

        $parser = app(ShortcodeParser::class);
        $rendered = $parser->parse($this->content);
        $this->update(['rendered_content' => $rendered]);

        return $rendered;
    }

    public function incrementViewCount(): void
    {
        $key = 'post_viewed_' . $this->id;
        if (!session()->has($key)) {
            $this->increment('view_count');
            session()->put($key, true);
        }
    }
}
