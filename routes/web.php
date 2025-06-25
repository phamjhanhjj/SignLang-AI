<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;

//Chuyển hướng sang dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

//Route cho dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/tables', [DashboardController::class, 'getTables']);
Route::get('/dashboard/data/{table}', [DashboardController::class, 'getTableData']);

//Route cho student
Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.show');
Route::post('/student', [StudentController::class, 'store'])->name('student.store');
Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

//Route cho student progress
use App\Http\Controllers\StudentProgressController;
Route::get('/student-progress/{student_id}', [StudentProgressController::class, 'show'])->name('student-progress.show');
Route::put('/student-progress/{student_id}', [StudentProgressController::class, 'update'])->name('student-progress.update');


//Route cho course
use App\Http\Controllers\CourseController;
Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
Route::post('/course', [CourseController::class, 'store'])->name('course.store');
Route::put('/course/{id}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/course/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
