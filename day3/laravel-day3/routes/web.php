<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/see/{id}', function ($id) {
   return view('see', [
    'id' => $id
   ]);
});