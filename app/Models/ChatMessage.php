<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'username',
        'avatar_color',
        'message',
        'type',
        'is_fake',
        'site',
        'likes',
    ];

    protected $casts = [
        'is_fake' => 'boolean',
        'likes' => 'integer',
    ];

    public function scopeForSite($query, ?string $site = null)
    {
        return $query->where(function ($q) use ($site) {
            $q->whereNull('site')->orWhere('site', $site);
        });
    }

    public function scopeRecent($query, int $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }
}
