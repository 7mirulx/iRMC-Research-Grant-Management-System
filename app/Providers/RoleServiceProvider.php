<?php

namespace App\Providers;

use App\Http\Middleware\CheckRole;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::aliasMiddleware('role', CheckRole::class);
    }
} 