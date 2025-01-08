<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Academician extends Model
{
    protected $fillable = [
        'staff_number',
        'name',
        'email',
        'position',
        'college',
        'department',
    ];

    // Projects where the academician is the leader
    public function ledProjects(): HasMany
    {
        return $this->hasMany(ResearchGrant::class, 'project_leader_id');
    }

    // Projects where the academician is a member
    public function memberProjects(): BelongsToMany
    {
        return $this->belongsToMany(ResearchGrant::class, 'project_members');
    }

    // Add this relationship with onDelete cascade
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
