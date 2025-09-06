<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResponderController;


// auth (login/register) 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/surveys', [SurveyController::class, 'index'])
    ->middleware('throttle:20,1'); // 30 requests per minute per IP

Route::get('/surveys/{id}', [SurveyController::class, 'show'])
    ->middleware('throttle:20,1');

// protected with JWT
Route::post('/surveys/{id}/submit', [SurveyController::class, 'submit'])
    ->middleware(['jwt.auth', 'throttle:submit-survey']);// rate limit for 5 requests per minute (AppServiceProvider)

Route::get('/me', [ResponderController::class, 'me'])
->middleware(['jwt.auth', 'throttle:me']);


