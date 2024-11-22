<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [RoomController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/room/{id}', [RoomController::class, 'joinRoom'])->middleware(['auth', 'verified'])->name('room');
Route::get('/preview/{id}', [RoomController::class, 'previewRoom'])->middleware(['auth', 'verified'])->name('previewRoom');
Route::get('/create-room', [RoomController::class, 'createRoom'])->middleware(['auth', 'verified'])->name('createRoom');
Route::post('/store-meeting', [RoomController::class, 'storeMeeting'])->middleware(['auth', 'verified'])->name('storeMeeting');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::post('/captions/start', [RoomController::class, 'startCaptions']);
// Route::post('/captions/{id}/stop', [RoomController::class, 'stopCaptions']);
require __DIR__.'/auth.php';
