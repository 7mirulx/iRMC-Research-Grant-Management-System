<?php

namespace App\Providers;

use App\Models\ResearchGrant;
use App\Policies\ResearchGrantPolicy;
use App\Models\Milestone;
use App\Policies\MilestonePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ResearchGrant::class => ResearchGrantPolicy::class,
        Milestone::class => MilestonePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
} 