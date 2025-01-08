<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Milestone;
use App\Models\ResearchGrant;

class MilestonePolicy
{
    public function update(User $user, Milestone $milestone)
    {
        // Allow admin
        if ($user->role === 'admin') {
            return true;
        }

        // Allow project leader of the research grant
        if ($user->academician_id === $milestone->researchGrant->project_leader_id) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Milestone $milestone)
    {
        return $this->update($user, $milestone);
    }

    public function create(User $user, ResearchGrant $research_grant)
    {
        // Allow admin
        if ($user->role === 'admin') {
            return true;
        }

        // Allow project leader of the research grant
        return $user->academician_id === $research_grant->project_leader_id;
    }

    public function store(User $user, ResearchGrant $research_grant)
    {
        return $this->create($user, $research_grant);
    }
} 