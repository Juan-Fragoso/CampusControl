<?php

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


});

require __DIR__.'/auth.php';
