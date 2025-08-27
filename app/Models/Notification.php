<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',          // marketing|invoices|system
        'short_text',
        'expires_at',
        'destination',   // all|user
        'created_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /* ---------- Relationships ---------- */

    public function deliveries(): HasMany
    {
        // who received it + read state
        return $this->hasMany(UserNotification::class);
    }

    /* ---------- Scopes ---------- */

    // not expired
    public function scopeActive(Builder $q): Builder
    {
        return $q->where('expires_at', '>', now());
    }

    // convenience: deliveries to a specific user
    public function scopeDeliveredTo(Builder $q, int $userId): Builder
    {
        return $q->whereHas('deliveries', fn ($d) => $d->where('user_id', $userId));
    }
}
