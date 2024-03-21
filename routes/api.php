<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProjectController;
use App\Http\Controllers\Api\v1\RegisterController;
use App\Http\Controllers\Api\v1\TaskController;
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

        // Projects
        Route::prefix('projects')->group(function () {

            Route::get('/', [ProjectController::class, 'index']);
            Route::post('/', [ProjectController::class, 'store']);
            Route::get('/{project}', [ProjectController::class, 'show']);
            Route::patch('/{project}', [ProjectController::class, 'update']);
            Route::delete('/{project}', [ProjectController::class, 'destroy']);

            // Tasks
            Route::get('/{project}/tasks', [TaskController::class, 'index']);
            Route::post('/{project}/tasks', [TaskController::class, 'store']);
            Route::get('/{project}/tasks/{task}', [TaskController::class, 'show']);
            Route::patch('/{project}/tasks/{task}', [TaskController::class, 'update']);
            Route::delete('/{project}/tasks/{task}', [TaskController::class, 'destroy']);

        });

    });

});
