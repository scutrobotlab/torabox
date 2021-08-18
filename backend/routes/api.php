<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\FakeMid;
use App\Http\Middleware\UserMid;

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


Route::get('/configs', [ConfigController::class, 'list']);

Route::prefix('/users')->group(function () {
    Route::prefix('/self')->group(function () {
        Route::get('/session', [UserController::class, 'isLoggedIn']);
        Route::post('/session', [UserController::class, 'login']);
    });
});

Route::middleware(UserMid::class)->group(function () {
    Route::prefix('/users')->group(function () {
        Route::get('/{id}', [UserController::class, 'index']);
        Route::prefix('/self')->group(function () {
            Route::get('/', [UserController::class, 'indexSelf']);
            Route::delete('/session', [UserController::class, 'logout']);
        });
    });
});

Route::middleware(FakeMid::class)->group(function () {
    Route::prefix('/users_fake')->group(function () {
        Route::get('/', [UserController::class, 'fakeList']);
        Route::get('/{id}', [UserController::class, 'fakeIndex']);
        Route::prefix('/self')->group(function () {
            Route::post('/session', [UserController::class, 'fakeLogin']);
        });
    });
});
