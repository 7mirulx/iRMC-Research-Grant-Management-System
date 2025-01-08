<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ResearchGrant;

class ResearchGrantPolicy
{
    public function manageMilestones(User $user, ResearchGrant $researchGrant): bool
    {
        return $user->academician && $user->academician->id === $researchGrant->project_leader_id;
    }

    public function update(User $user, ResearchGrant $researchGrant): bool
    {
        return $user->isAdmin() || 
               ($user->academician && $user->academician->id === $researchGrant->project_leader_id);
    }
} 