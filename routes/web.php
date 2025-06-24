<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

//Chuyển hướng sang dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

//Route cho dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/tables', [DashboardController::class, 'getTables']);
Route::get('/dashboard/data/{table}', [DashboardController::class, 'getTableData']);

//Route cho student
Route::get('/student/{id}', [App\Http\Controllers\StudentController::class, 'show'])->name('student.show');
Route::post('/student', [App\Http\Controllers\StudentController::class, 'store'])->name('student.store');
Route::put('/student/{id}', [App\Http\Controllers\StudentController::class, 'update'])->name('student.update');
Route::delete('/student/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('student.destroy');
