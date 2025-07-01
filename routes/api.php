<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentApiController;

// Route cho API sinh viên
Route::post('/sign-up', [StudentApiController::class, 'receiveUserId'])->name('api.student.receiveUserId');
