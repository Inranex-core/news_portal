<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'image',
        'video',
        'video_url',
        'url',
        'placement',
        'status',
        'clicks',
        'impressions',
    ];

    protected $casts = [
        'status' => 'boolean',
        'clicks' => 'integer',
        'impressions' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopePlacement($query, string $placement)
    {
        return $query->where('placement', $placement);
    }
}
