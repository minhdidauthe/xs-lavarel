<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shortcode extends Model
{
    protected $fillable = ['name', 'code', 'content', 'description', 'is_active', 'is_builtin'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'is_builtin' => 'boolean'];
    }
}
