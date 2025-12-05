<?php

use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('organizers', OrganizerController::class);
Route::resource('events', EventController::class);
