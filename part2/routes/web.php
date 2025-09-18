<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\TabelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TabelController::class, 'index']);

Route::get('/see/{id}', [TabelController::class, 'show']);

Route::get('/buku', [BukuController::class, 'index']);