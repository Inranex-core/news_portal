<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'is_approved',
    'otp_code',
    'otp_expires_at',
    'invite_token',
])]
#[Hidden([
    'password',
    'remember_token',
    'otp_code',
    'invite_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the journalist profile associated with the user.
     */
    public function journalistProfile(): HasOne
    {
        return $this->hasOne(JournalistProfile::class);
    }

    /**
     * Check if user is a journalist.
     */
    public function isJournalist(): bool
    {
        return $this->role === 'journalist';
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is approved.
     */
    public function isApproved(): bool
    {
        return (bool) $this->is_approved;
    }

    /**
     * Verify if provided OTP code matches and is not expired.
     */
    public function isValidOtp(string $code): bool
    {
        if (empty($this->otp_code) || $this->otp_code !== trim($code)) {
            return false;
        }

        if ($this->otp_expires_at && $this->otp_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'is_approved' => 'boolean',
            'password' => 'hashed',
        ];
    }
}