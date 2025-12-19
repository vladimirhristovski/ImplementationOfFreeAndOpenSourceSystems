<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;

Route::apiResource('courses', CourseController::class);

Route::post('enrollments', [EnrollmentController::class, 'store']);
Route::put('enrollments/{enrollment}/approve', [EnrollmentController::class, 'approve']);
Route::put('enrollments/{enrollment}/drop', [EnrollmentController::class, 'drop']);
