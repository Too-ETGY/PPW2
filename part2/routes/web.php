<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\TabelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TabelController::class, 'index']);

Route::get('/see/{id}', [TabelController::class, 'show']);

Route::get('/buku', [BukuController::class, 'index'])->name('buku');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/edit/{id}', [BukuController::class, 'update'])->name('buku.update');