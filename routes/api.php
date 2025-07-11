<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentApiController;

// Test route
Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});

// Route cho API sinh viên
Route::post('/student', [StudentApiController::class, 'receiveUserId'])->name('api.student.receiveUserId');
Route::put('/student/{StudentId}', [StudentApiController::class, 'update'])->name('api.student.update');

// Route cho API học tập
use App\Http\Controllers\Api\LearnApiController;
Route::post('/learn', [LearnApiController::class, 'getlearn'])->name('api.learn.getlearn');

// Route cho API tiến độ học sinh
use App\Http\Controllers\Api\StudentProgressApiController;
Route::get('/user-metric/{studentId}', [StudentProgressApiController::class, 'getStudentProgress'])->name('api.student-progress.getStudentProgress');
