<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
// use GuzzleHttp\Middleware;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/about', fn () => view('about'));

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware(AuthController::class)->group(function() {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');    
   
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::prefix('admin')->middleware(IsAdmin::class)->group(function() {
        Route::get('/', function() {
            return view('admin.index');
        })->name('admin');

        Route::get('/jobs', function() {
            return view('admin.job');
        })->name('admin.jobs');
    });
});