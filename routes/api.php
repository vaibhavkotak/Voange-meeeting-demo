<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/captions/start', [RoomController::class, 'startCaptionsShow']);
Route::post('/captions/{id}/stop', [RoomController::class, 'stopCaptions']);