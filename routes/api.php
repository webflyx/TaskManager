<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProjectController;
use App\Http\Controllers\Api\v1\RegisterController;
use App\Http\Controllers\Api\v1\TaskController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::get('user-data', [AuthController::class, 'userData'])->middleware(['auth:api']);

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
            Route::post('/', [ProjectController::class, 'store'])->middleware('can:create,App\Models\Project');
            Route::get('/{project}', [ProjectController::class, 'show'])->middleware('can:view,project');
            Route::patch('/{project}', [ProjectController::class, 'update'])->middleware('can:update,project');
            Route::delete('/{project}', [ProjectController::class, 'destroy'])->middleware('can:delete,project');

            // Tasks
            Route::get('/{project}/tasks', [TaskController::class, 'index'])->middleware('can:viewAny,App\Models\Task,project');
            Route::post('/{project}/tasks', [TaskController::class, 'store'])->middleware('can:create,App\Models\Task,project');
            Route::get('/{project}/tasks/{task}', [TaskController::class, 'show'])->middleware('can:view,task');
            Route::patch('/{project}/tasks/{task}', [TaskController::class, 'update'])->middleware('can:update,task');
            Route::delete('/{project}/tasks/{task}', [TaskController::class, 'destroy'])->middleware('can:delete,task');

        });

    });

});
