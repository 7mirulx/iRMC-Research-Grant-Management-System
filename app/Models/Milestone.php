<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
    protected $fillable = [
        'research_grant_id',
        'name',
        'deliverable',
        'target_completion_date',
        'status',
        'last_updated'
    ];

    protected $casts = [
        'target_completion_date' => 'date',
        'last_updated' => 'datetime'
    ];

    public function researchGrant(): BelongsTo
    {
        return $this->belongsTo(ResearchGrant::class);
    }
}
