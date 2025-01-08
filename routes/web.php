<?php

use App\Http\Controllers\AcademicianController;
use App\Http\Controllers\ResearchGrantController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('academicians', AcademicianController::class)
            ->except(['show']);
        Route::post('research-grants', [ResearchGrantController::class, 'store'])
            ->name('research-grants.store');
        Route::get('research-grants/create', [ResearchGrantController::class, 'create'])
            ->name('research-grants.create');
        Route::delete('academicians/{academician}', [AcademicianController::class, 'destroy'])
            ->name('academicians.destroy');
        Route::delete('research-grants/{research_grant}', [ResearchGrantController::class, 'destroy'])
            ->name('research-grants.destroy');
        Route::delete('milestones/{milestone}', [MilestoneController::class, 'destroy'])
            ->name('milestones.destroy');
        Route::resource('milestones', MilestoneController::class)->only(['index', 'destroy']);

        // Full milestone management for admin
        Route::get('milestones', [MilestoneController::class, 'index'])->name('milestones.index');
        Route::get('milestones/create', [MilestoneController::class, 'create'])->name('milestones.create');
        Route::post('milestones', [MilestoneController::class, 'store'])->name('milestones.store');
        Route::get('milestones/{milestone}/edit', [MilestoneController::class, 'edit'])->name('milestones.edit');
        Route::put('milestones/{milestone}', [MilestoneController::class, 'update'])->name('milestones.update');
        Route::delete('milestones/{milestone}', [MilestoneController::class, 'destroy'])->name('milestones.destroy');
        Route::post('milestones/admin-store', [MilestoneController::class, 'adminStore'])->name('milestones.admin.store');
    });

    // Shared routes
    Route::get('academicians/{academician}', [AcademicianController::class, 'show'])
        ->name('academicians.show');

    // Research Grant routes accessible by all authenticated users
    Route::get('research-grants', [ResearchGrantController::class, 'index'])
        ->name('research-grants.index');
    Route::get('research-grants/{research_grant}', [ResearchGrantController::class, 'show'])
        ->name('research-grants.show');

    // Routes that require authorization
    Route::middleware('can:update,research_grant')->group(function () {
        Route::get('research-grants/{research_grant}/edit', [ResearchGrantController::class, 'edit'])
            ->name('research-grants.edit');
        Route::put('research-grants/{research_grant}', [ResearchGrantController::class, 'update'])
            ->name('research-grants.update');
    });

    // Milestone routes (for both admin and project leaders)
    Route::middleware('auth')->group(function () {
        // Status update routes
        Route::get('milestones/{milestone}/status', [MilestoneController::class, 'editStatus'])
            ->name('milestones.editstatus')
            ->middleware('can:update,milestone');
        
        Route::put('milestones/{milestone}/status', [MilestoneController::class, 'updateStatus'])
            ->name('milestones.updatestatus')
            ->middleware('can:update,milestone');

        // Store milestone route
        Route::post('research-grants/{research_grant}/milestones', [MilestoneController::class, 'store'])
            ->name('milestones.store')
            ->middleware('can:store,App\Models\Milestone,research_grant');
    });

    // Remove or comment out these duplicate routes
    // Route::resource('milestones', MilestoneController::class)
    //     ->except(['store'])
    //     ->middleware('can:update,milestone');

    // Route::middleware('can:manage-milestones,research_grant')->group(function () {
    //     Route::post('research-grants/{research_grant}/milestones', [MilestoneController::class, 'store'])
    //         ->name('milestones.store');
    // });
});
