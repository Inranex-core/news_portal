<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalistProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'designation',
        'designation_bn',
        'organization',
        'organization_bn',
        'headline',
        'bio',
        'bio_bn',
        'profile_image',
        'cover_image',
        'location',
        'phone',
        'website',
        'experience_years',
        'is_verified',
        'status',
    ];

    /**
     * Cast model attributes to native PHP types.
     */
    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'is_verified' => 'boolean',
            'status' => 'boolean',
        ];
    }

    /* Dynamic Accessors for Bilingual Support */
    public function getDisplayDesignationAttribute(): string
    {
        if (app()->getLocale() === 'bn' && !empty($this->designation_bn)) {
            return $this->designation_bn;
        }
        return $this->designation ?? __('Reporter');
    }

    public function getDisplayOrganizationAttribute(): ?string
    {
        if (app()->getLocale() === 'bn' && !empty($this->organization_bn)) {
            return $this->organization_bn;
        }
        return $this->organization;
    }

    public function getDisplayBioAttribute(): ?string
    {
        if (app()->getLocale() === 'bn' && !empty($this->bio_bn)) {
            return $this->bio_bn;
        }
        return $this->bio;
    }

    /**
     * Journalist profile belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /**
     * Journalist has many professional experiences.
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(
            JournalistExperience::class,
            'journalist_profile_id'
        );
    }

    /**
     * Journalist has many educational records.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(
            JournalistEducation::class,
            'journalist_profile_id'
        );
    }

    /**
     * Journalist has many awards.
     */
    public function awards(): HasMany
    {
        return $this->hasMany(
            JournalistAward::class,
            'journalist_profile_id'
        );
    }

    /**
     * Journalist has many areas of expertise.
     */
    public function expertises(): BelongsToMany
    {
        return $this->belongsToMany(
            Expertise::class,
            'journalist_expertise',
            'journalist_profile_id',
            'expertise_id'
        );
    }

    public function articles(): HasMany
    {
        return $this->hasMany(
            Article::class,
            'journalist_profile_id'
        );
    }   
}