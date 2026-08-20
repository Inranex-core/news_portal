<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Expertise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function journalists(): BelongsToMany
    {
        return $this->belongsToMany(
            JournalistProfile::class,
            'journalist_expertise',
            'expertise_id',
            'journalist_profile_id'
        );
    }
}