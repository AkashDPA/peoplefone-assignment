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
        'expires_at' => 'date:Y-m-d',
    ];

    /* ---------- Relationships ---------- */

    public function deliveries(): HasMany
    {
        // who received it + read state
        return $this->hasMany(UserNotification::class);
    }
}
