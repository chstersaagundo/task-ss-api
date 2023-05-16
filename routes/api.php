<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\BlockWebsiteController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TaskScheduleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\User\UserAuthController;

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

        //User Routes
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::get('/profile', [UserController::class, 'getProfile']);
        Route::patch('/profile', [UserController::class, 'updateProfile']);
        Route::post('/password/reset', [UserController::class, 'changePassword']);
        Route::delete('/deleteUser/{id}', [UserController::class, 'destroy']);
        //Category Routes
        Route::resource('categories', CategoryController::class);

        //Task Routes
        Route::get('/tasks/recent', [TaskController::class, 'recent']);
        Route::get('/tasks/filter', [TaskController::class, 'filter']);
        Route::get('tasks/starred', [TaskController::class, 'allStarredTasks']);
        Route::get('tasks/type/{id}', [TaskController::class, 'getTaskType']);
        Route::get('tasks/category/{id}', [TaskController::class, 'allTasksByCategory']);
        Route::get('/tasks/sortfilter/{by?}/{order?}', [TaskController::class, 'sortFilter']);
        // Route::get('tasks/{by}/{order}/{category?}/{id?}', [TaskController::class, 'sort']);
        Route::resource('tasks', TaskController::class);
        Route::get('/exporttasks', [TaskController::class, 'exportAll']);
        Route::get('/exporttasks/{priority}', [TaskController::class, 'export']);


        
        //Feedback Routes
        Route::resource('feedbacks', FeedbackController::class);

        //BlockWebsites Routes
        Route::get('blockwebsites/includes', [BlockWebsiteController::class, 'allIncludes']);
        Route::resource('blockwebsites', BlockWebsiteController::class);

        Route::post('/subscriptions/subscribe', [SubscriptionController::class, 'storeSubData']);
        Route::get('/subscriptions/currentplan', [SubscriptionController::class, 'currentPlan']);
        Route::get('/subscriptions/all', [SubscriptionController::class, 'allSubscriptions']);
        Route::resource('subscriptions', SubscriptionController::class);


        Route::resource('notifications', NotificationController::class);
    });

});
Route::get('/feedbacks/all', [FeedbackController::class, 'allFeedbacks']);

Route::post('/schedule', [TaskScheduleController::class, 'store']);

Route::post('/sendmail/{email}', [EmailController::class, 'sendMail']);