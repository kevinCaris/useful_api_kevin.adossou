<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShortLinkController;

use App\Http\Controllers\Api\ModulesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/modules', [ModulesController::class, 'index']);
    Route::post('/modules/{id}/activate', [ModulesController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [ModulesController::class, 'deactivate']);

    Route::post('/shorten',  [ModulesController::class, 'shorten']);

});


Route::get('/s/{code}', [ShortLinkController::class, 'redirect']);

Route::middleware(['auth:sanctum', 'module.active:1'])->group(function () {
    Route::post('/shorten', [ShortLinkController::class, 'store']);
    Route::get('/links', [ShortLinkController::class, 'index']);
    Route::delete('/links/{id}', [ShortLinkController::class, 'destroy']);
});
