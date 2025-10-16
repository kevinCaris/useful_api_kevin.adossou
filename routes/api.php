<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ModulesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/modules', [ModulesController::class, 'index']);
    Route::post('/modules/{id}/activate', [ModulesController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [ModulesController::class, 'deactivate']);
});
