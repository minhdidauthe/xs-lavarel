<?php

namespace App\Models;

use App\Services\ShortcodeParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'author_id', 'title', 'slug', 'content', 'rendered_content',
        'meta_title', 'meta_description', 'template', 'status', 'sort_order',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published');
    }

    protected static function booted(): void
    {
        static::creating(function (Page $page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function (Page $page) {
            if ($page->isDirty('content')) {
                $page->rendered_content = null;
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
}
