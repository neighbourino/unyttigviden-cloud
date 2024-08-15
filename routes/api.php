<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FactController;


Route::group(['prefix' => 'v1'], function () {
    Route::get('/facts', [FactController::class, 'index'])->name('api.facts.index');
    Route::get('/facts/{fact}', [FactController::class, 'show'])->name('api.facts.show');


    // login route
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('api.forgot-password');


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        })->middleware('auth:sanctum');

        Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    });
});
