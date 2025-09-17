<?php

namespace App\Models;

use App\Enums\IncidentSeverity;
use App\Enums\IncidentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'severity', 'status', 'assigned_to'
    ];

    protected $casts = [
        'severity' => IncidentSeverity::class,
        'status' => IncidentStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(IncidentComment::class)->latest();
    }

    public function activities(): HasMany
    {
        return $this->hasMany(IncidentActivity::class)->latest();
    }
}
