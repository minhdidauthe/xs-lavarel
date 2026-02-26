<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryResult extends Model
{
    protected $table = 'lottery_results';

    protected $fillable = [
        'date',
        'region',
        'province',
        'prizes',
        'numbers',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'prizes' => 'array',
            'numbers' => 'array',
        ];
    }
}
