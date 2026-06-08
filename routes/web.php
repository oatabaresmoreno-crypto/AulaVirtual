<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\AssignmentController as AdminAssignmentController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\LessonController as InstructorLessonController;
use App\Http\Controllers\Instructor\AssignmentController as InstructorAssignmentController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\EnrollmentController as StudentEnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// — Admin —
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('courses', AdminCourseController::class);
    Route::resource('lessons', AdminLessonController::class);
    Route::resource('assignments', AdminAssignmentController::class);
    Route::resource('enrollments', AdminEnrollmentController::class);
});

// — Instructor —
Route::prefix('instructor')->name('instructor.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('courses', InstructorCourseController::class);
    Route::resource('lessons', InstructorLessonController::class);
    Route::resource('assignments', InstructorAssignmentController::class);
});

// — Student —
Route::prefix('student')->name('student.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('courses', StudentCourseController::class)->only(['index', 'show']);
    Route::resource('enrollments', StudentEnrollmentController::class)->only(['index', 'show', 'store', 'destroy']);
});

require __DIR__.'/auth.php';