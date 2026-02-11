<?php

use App\Http\Controllers\CourseAssignmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
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

    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/save', [StudentController::class, 'saveUpdate'])->name('students.save');
    Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->name('students.edit');

    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers/save', [TeacherController::class, 'saveUpdate'])->name('teachers.save');
    Route::get('/teacher/edit/{id}', [TeacherController::class, 'edit'])->name('teachers.edit');

    Route::get('/course-assignment', [CourseAssignmentController::class, 'index'])->name('course-assignments');
    Route::post('/course-assignment/save', [CourseAssignmentController::class, 'save'])->name('course-assignments.save');

    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments');
    Route::post('/enrollments/save', [EnrollmentController::class,'saveUpdate'])->name('entollment.save');

});

require __DIR__.'/auth.php';
