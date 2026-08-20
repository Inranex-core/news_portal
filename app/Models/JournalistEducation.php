<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalistEducation extends Model
{
    use HasFactory;

    protected $table = 'journalist_education';

    protected $fillable = [
        'journalist_profile_id',
        'institution',
        'degree',
        'field_of_study',
        'start_year',
        'end_year',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_year' => 'integer',
            'end_year' => 'integer',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(
            JournalistProfile::class,
            'journalist_profile_id'
        );
    }
}