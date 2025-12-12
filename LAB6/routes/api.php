<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/events')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::post('/', [EventController::class, 'store']);
    Route::get('/{id}', [EventController::class, 'show']);
    Route::put('/{id}', [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'destroy']);
});

Route::prefix('/organizers')->group(function () {
    Route::get('/', [OrganizerController::class, 'index']);
    Route::post('/', [OrganizerController::class, 'store']);
    Route::get('/{id}', [OrganizerController::class, 'show']);
    Route::put('/{id}', [OrganizerController::class, 'update']);
    Route::delete('/{id}', [OrganizerController::class, 'destroy']);
});
