<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentActivity extends Model
{
    protected $fillable = ['incident_id','user_id','type','data'];

    protected $casts = [
        'data' => 'array',
    ];

    public function incident(): BelongsTo { return $this->belongsTo(Incident::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
