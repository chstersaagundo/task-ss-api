<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function() {
    Route::prefix("auth")->group(function() {
        Route::post('/register', [UserAuthController::class, 'register']);
        Route::post('/login', [UserAuthController::class, 'login']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::post('/auth/logout', [UserAuthController::class, 'logout']);
        Route::resource('categories', CategoryController::class);
        Route::get('tasks/all/{id}', [TaskController::class, 'allTasksById']);
        Route::get('tasks/allstarred', [TaskController::class, 'allStarredTasks']);
        Route::resource('tasks', TaskController::class);
    });
});


