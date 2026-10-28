<?php

use App\Http\Controllers\BengkelController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('bengkel.index'));

Route::resource('bengkel', BengkelController::class);
