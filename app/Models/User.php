<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'total_points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_points' => 'integer',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }

    public function wasteTransactions(): HasMany
    {
        return $this->hasMany(WasteTransaction::class, 'user_id');
    }

    public function verifiedTransactions(): HasMany
    {
        return $this->hasMany(WasteTransaction::class, 'verified_by');
    }

    public function pointRedemptions(): HasMany
    {
        return $this->hasMany(PointRedemption::class, 'user_id');
    }
}
