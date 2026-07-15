<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use Illuminate\Support\Facades\Route;

// — Rutas públicas (sin autenticación) —
Route::post('/login', [AuthController::class, 'login']);

// — Rutas protegidas (requieren token) —
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Courses
    Route::apiResource('courses', CourseController::class);

    // Lessons
    Route::apiResource('lessons', LessonController::class);

});