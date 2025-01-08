<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    protected $fillable = [
        'research_grant_id',
        'academician_id'
    ];
}
