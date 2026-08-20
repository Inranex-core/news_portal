<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalistExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'journalist_profile_id',
        'organization',
        'designation',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
        ];
    }

    /**
     * Journalist profile.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(
            JournalistProfile::class,
            'journalist_profile_id'
        );
    }
}