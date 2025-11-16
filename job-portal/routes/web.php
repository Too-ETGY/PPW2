<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', fn () => view('welcome'));
Route::get('/about', fn () => view('about'));

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated users
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Authenticated job listings
    Route::resource('jobs', JobController::class)->only(['index', 'show']);
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->name('apply.store');

    // Admin-only routes
    Route::middleware(IsAdmin::class)->group(function () {

        Route::get('/admin', function () {
            return view('admin.index');
        })->name('admin');

        // Admin job management
        Route::resource('jobs', JobController::class)
            ->except(['index', 'show']);

        // Applicant list per job
        Route::get('/applicants', [ApplicationController::class, 'index'])
            ->name('applications.index');

        Route::get('/applicants/{application}', [ApplicationController::class, 'filter'])
            ->name('applications.filter');

        // Update application status
        Route::put('/applications/{application}', [ApplicationController::class, 'update'])
            ->name('applications.update');

        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])
            ->name('applications.destroy');

        // Export applications
        Route::get('/applications/export', [ApplicationController::class, 'export'])
            ->name('applications.export');

        // Import jobs
        Route::post('/jobs/import', [JobController::class, 'import'])
            ->name('jobs.import');

        Route::get('/jobs/import/template', [JobController::class, 'downloadImportTemplate'])
            ->name('jobs.import.template');
    });
});
