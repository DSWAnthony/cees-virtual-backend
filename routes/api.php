<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/courses',[CourseController::class, 'store']);
Route::put('/courses/{id}',[CourseController::class, 'update']);
Route::get('/courses', [CourseController::class, 'index']);

Route::post('/modules', [ModuleController::class, 'store']);
