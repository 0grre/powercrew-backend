<?php

use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use App\Models\UserHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

/* --- Connected customer --- */
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {

        $user_last_login = UserHistory::where('user_id', $request->user()->id)->first() ?? new UserHistory();
        $user_last_login->last_login();

        return $request->user();
    });

    /* --- Users --- */
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    Route::group(['middleware' => ['role:super-admin|admin|ambassador']], function () {
        /* --- Team --- */
        Route::get('/teams', [TeamController::class, 'index']);
        Route::get('/teams/{id}', [TeamController::class, 'show']);
        Route::get('/teams/{id}', [TeamController::class, 'store']);

        Route::group(['middleware' => ['role:super-admin|admin']], function () {
            /* --- Users --- */
            Route::get('/users', [UserController::class, 'index']);
            Route::post('/users', [UserController::class, 'store']);
            Route::delete('/users/{id}', [UserController::class, 'destroy']);

            /* --- Team --- */
            Route::get('/teams/{id}', [TeamController::class, 'destroy']);
        });
    });
});

Route::get('/test', function () {

});
