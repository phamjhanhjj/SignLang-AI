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
Route::get('/students', [StudentController::class, 'index'])->name('student.index');
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
Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
Route::post('/course', [CourseController::class, 'store'])->name('course.store');
Route::put('/course/{id}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/course/{id}', [CourseController::class, 'destroy'])->name('course.destroy');

//Route cho topic
use App\Http\Controllers\TopicController;
Route::get('/topics', [TopicController::class, 'index'])->name('topic.index');
Route::get('/topic/{id}', [TopicController::class, 'show'])->name('topic.show');
Route::post('/topic', [TopicController::class, 'store'])->name('topic.store');
Route::put('/topic/{id}', [TopicController::class, 'update'])->name('topic.update');
Route::delete('/topic/{id}', [TopicController::class, 'destroy'])->name('topic.destroy');

//Route cho word
use App\Http\Controllers\WordController;
Route::get('/words', [WordController::class, 'index'])->name('word.index');
Route::get('/word/{id}', [WordController::class, 'show'])->name('word.show');
Route::post('/word', [WordController::class, 'store'])->name('word.store');
Route::put('/word/{id}', [WordController::class, 'update'])->name('word.update');
Route::delete('/word/{id}', [WordController::class, 'destroy'])->name('word.destroy');

//Route cho learn videos
use App\Http\Controllers\LearnVideosController;
Route::get('/learn-videos', [LearnVideosController::class, 'index'])->name('learn-video.index');
Route::get('/learn-video/{id}', [LearnVideosController::class, 'show'])->name('learn-video.show');
Route::post('/learn-video', [LearnVideosController::class, 'store'])->name('learn-video.store');
Route::put('/learn-video/{id}', [LearnVideosController::class, 'update'])->name('learn-video.update');
Route::delete('/learn-video/{id}', [LearnVideosController::class, 'destroy'])->name('learn-video.destroy');

//Route cho practise video
use App\Http\Controllers\PractiseVideoController;
Route::get('/practise-videos', [PractiseVideoController::class, 'index'])->name('practise-video.index');
Route::get('/practise-video/{id}', [PractiseVideoController::class, 'show'])->name('practise-video.show');
Route::post('/practise-video', [PractiseVideoController::class, 'store'])->name('practise-video.store');
Route::put('/practise-video/{id}', [PractiseVideoController::class, 'update'])->name('practise-video.update');
Route::delete('/practise-video/{id}', [PractiseVideoController::class, 'destroy'])->name('practise-video.destroy');

//Route cho word practise video
use App\Http\Controllers\WordPractiseVideoController;
Route::get('/word-practise-videos', [WordPractiseVideoController::class, 'index'])->name('word-practise-video.index');
Route::get('/word-practise-video/{id}', [WordPractiseVideoController::class, 'show'])->name('word-practise-video.show');
Route::post('/word-practise-video', [WordPractiseVideoController::class, 'store'])->name('word-practise-video.store');
Route::put('/word-practise-video/{id}', [WordPractiseVideoController::class, 'update'])->name('word-practise-video.update');
Route::delete('/word-practise-video/{id}', [WordPractiseVideoController::class, 'destroy'])->name('word-practise-video.destroy');

//Route cho enrolment
use App\Http\Controllers\EnrolmentController;
Route::get('/enrolments', [EnrolmentController::class, 'index'])->name('enrolment.index');
Route::get('/enrolment/{id}', [EnrolmentController::class, 'show'])->name('enrolment.show');
Route::post('/enrolment', [EnrolmentController::class, 'store'])->name('enrolment.store');
Route::put('/enrolment/{id}', [EnrolmentController::class, 'update'])->name('enrolment.update');
Route::delete('/enrolment/{id}', [EnrolmentController::class, 'destroy'])->name('enrolment.destroy');
