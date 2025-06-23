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
