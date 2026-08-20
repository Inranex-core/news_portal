<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bn',
        'slug',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get display name based on current locale.
     */
    public function getDisplayNameAttribute(): string
    {
        if (app()->getLocale() === 'bn') {
            if (!empty($this->name_bn)) {
                return $this->name_bn;
            }
            return __($this->name);
        }
        return $this->name;
    }

    /**
     * Category has many articles.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(
            Article::class,
            'category_id'
        );
    }
}