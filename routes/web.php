<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/widget', fn () => view('widget'));

Route::get('/dashboard', [TicketController::class, 'index'])
    ->middleware(['auth', 'verified', IsManager::class])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', IsManager::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
});

require __DIR__.'/auth.php';
