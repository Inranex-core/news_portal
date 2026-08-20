<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalistAward extends Model
{
    use HasFactory;

    protected $fillable = [
        'journalist_profile_id',
        'title',
        'organization',
        'award_year',
        'description',
        'certificate_url',
    ];

    protected $casts = [
        'award_year' => 'integer',
    ];

    public function journalist()
    {
        return $this->belongsTo(
            JournalistProfile::class,
            'journalist_profile_id'
        );
    }
}