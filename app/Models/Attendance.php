<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'panitia_id',
        'peserta_id',
        'event_date',
        'status',
        'scanned_at',
    ];

    protected $casts = [
        'event_date' => 'date',
        'scanned_at' => 'datetime',
    ];

    // Relationship with Panitia
    public function panitia(): BelongsTo
    {
        return $this->belongsTo(Panitia::class);
    }

    // Relationship with Peserta
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }

    // Scope for today's attendances
    public function scopeToday($query)
    {
        return $query->whereDate('event_date', today());
    }

    // Scope for present attendances
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }
}
