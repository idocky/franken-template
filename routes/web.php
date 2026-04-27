<?php

use App\Http\Controllers\SpinController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::middleware('spin.fresh')->group(function () {
    Route::get('/spins/{uuid}', [SpinController::class, 'index'])->name('spins.index');
    Route::get('/spins/{uuid}/history', [SpinController::class, 'history'])->name('spins.history');
    Route::post('/spins/{uuid}', [SpinController::class, 'store'])->name('spins.store');
    Route::post('/spins/{uuid}/regenerate', [SpinController::class, 'regenerate'])->name('spins.regenerate');
    Route::post('/spins/{uuid}/deactivate', [SpinController::class, 'deactivate'])->name('spins.deactivate');
});
