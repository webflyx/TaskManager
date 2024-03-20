<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProjectController;
use App\Http\Controllers\Api\v1\RegisterController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('/email', [AuthController::class, 'loginByEmail']);

        Route::middleware('auth:api')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });

    // Register
    Route::prefix('register')->group(function () {
        Route::post('/email', [RegisterController::class, 'registerByEmail']);
    });


    // Auth Middleware
    Route::middleware('auth:api')->group(function () {

        Route::prefix('projects')->group(function () {

           Route::post('/', [ProjectController::class, 'store']);
           Route::delete('/{project}', [ProjectController::class, 'destroy']);

        });

    });

});
