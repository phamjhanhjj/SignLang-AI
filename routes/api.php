<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentApiController;

// Test route
Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});

// Route cho API sinh viên
Route::post('/student', [StudentApiController::class, 'receiveUserId'])->name('api.student.receiveUserId');
