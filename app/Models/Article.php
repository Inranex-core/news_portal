<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'journalist_profile_id',
        'category_id',
        'title',
        'title_bn',
        'slug',
        'excerpt',
        'excerpt_bn',
        'content',
        'content_bn',
        'image',
        'status',
        'rejection_reason',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /* Dynamic Accessors for Bilingual Support */
    public function getDisplayTitleAttribute(): string
    {
        if (app()->getLocale() === 'bn') {
            return !empty($this->title_bn) ? $this->title_bn : ($this->title ?? '');
        }
        return !empty($this->title) ? $this->title : ($this->title_bn ?? '');
    }

    public function getDisplayExcerptAttribute(): ?string
    {
        if (app()->getLocale() === 'bn') {
            return !empty($this->excerpt_bn) ? $this->excerpt_bn : $this->excerpt;
        }
        return !empty($this->excerpt) ? $this->excerpt : $this->excerpt_bn;
    }

    public function getDisplayContentAttribute(): string
    {
        if (app()->getLocale() === 'bn') {
            return !empty($this->content_bn) ? $this->content_bn : ($this->content ?? '');
        }
        return !empty($this->content) ? $this->content : ($this->content_bn ?? '');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Journalist & Relationships
    |--------------------------------------------------------------------------
    */

    public function journalist(): BelongsTo
    {
        return $this->belongsTo(
            JournalistProfile::class,
            'journalist_profile_id'
        );
    }

    public function journalistProfile(): BelongsTo
    {
        return $this->belongsTo(
            JournalistProfile::class,
            'journalist_profile_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query
            ->where('status', 'published')
            ->whereNotNull('published_at');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeForLocale($query, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $driver = $query->getConnection()->getDriverName();

        if ($locale === 'bn') {
            return $query->where(function ($q) use ($driver) {
                $q->where(function ($sub) {
                    $sub->whereNotNull('title_bn')
                        ->where('title_bn', '!=', '');
                });

                // Detect Bengali-script characters by their UTF-8 byte ranges (E0A6**, E0A7**).
                // HEX() is supported by both MySQL and SQLite.
                $q->orWhereRaw("HEX(title) LIKE '%E0A6%'")
                  ->orWhereRaw("HEX(title) LIKE '%E0A7%'");
            });
        } else {
            return $query->where(function ($q) use ($driver) {
                $q->where(function ($sub) {
                    $sub->whereNotNull('title_bn')
                        ->where('title_bn', '!=', '')
                        ->whereNotNull('title')
                        ->where('title', '!=', '');
                })
                ->orWhere(function ($sub) use ($driver) {
                    $sub->where(function ($s) {
                        $s->whereNull('title_bn')->orWhere('title_bn', '');
                    })
                    ->whereRaw("HEX(title) NOT LIKE 'E0A6%' AND HEX(title) NOT LIKE 'E0A7%'");

                    if ($driver === 'mysql') {
                        $sub->where('title', 'REGEXP', '[a-zA-Z]');
                    } elseif ($driver === 'sqlite') {
                        // SQLite: use GLOB (built-in, no extension required) for ASCII-letter presence.
                        $sub->where('title', 'GLOB', '*[a-zA-Z]*');
                    } else {
                        $sub->whereRaw("title ~ '[a-zA-Z]'");
                    }
                });
            });
        }
    }
}