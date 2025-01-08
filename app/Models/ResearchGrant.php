<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResearchGrant extends Model
{
    protected $fillable = [
        'project_leader_id',
        'title',
        'grant_amount',
        'grant_provider',
        'start_date',
        'duration_months',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function projectLeader(): BelongsTo
    {
        return $this->belongsTo(Academician::class, 'project_leader_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Academician::class, 'project_members');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class);
    }
}
