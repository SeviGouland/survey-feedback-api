<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResponderController;


// auth (login/register) 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/surveys', [SurveyController::class, 'index']);
Route::get('/surveys/{id}', [SurveyController::class, 'show']);

// protected with JWT
Route::middleware('jwt.auth')->group(function () {
    Route::post('/surveys/{id}/submit', [SurveyController::class, 'submit']);
    Route::get('/me', [ResponderController::class, 'me']);
});

