<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointRedemption extends Model
{
    protected $fillable = [
        'user_id',
        'points_used',
        'rupiah_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'points_used' => 'integer',
            'rupiah_amount' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
