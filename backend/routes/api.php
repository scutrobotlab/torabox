<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\ConsumableApplicationController;
use App\Http\Controllers\ConsumablePurchaseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\FakeMid;
use App\Http\Middleware\UserMid;
use App\Http\Middleware\EnsureUserInGroup;

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
            Route::put('/', [UserController::class, 'updateSelf']);
            Route::delete('/session', [UserController::class, 'logout']);
        });
    });

    Route::prefix('/groups')->group(function () {
        Route::get('/', [GroupController::class, 'list']);
        Route::prefix('/{id}')->group(function () {
            Route::get('/', [GroupController::class, 'index']);
            Route::get('/users', [GroupController::class, 'indexUserList']);
            Route::get('/members', [GroupController::class, 'indexMemberList']);
            Route::get('/leaders', [GroupController::class, 'indexLeaderList']);
        });
    });

    Route::prefix('/subscriptions')->group(function () {
        Route::get('/', [SubscriptionController::class, 'list']);
        Route::get('/{id}', [SubscriptionController::class, 'index']);
        Route::get('/{id}/edit', [SubscriptionController::class, 'edit']);
        Route::delete('/{id}', [SubscriptionController::class, 'destroy']);
        Route::middleware(EnsureUserInGroup::class)->group(function () {
            Route::post('/', [SubscriptionController::class, 'store']);
            Route::put('/{id}', [SubscriptionController::class, 'update']);
        });
    });

    Route::prefix('/consumables')->group(function () {
        Route::get('/', [ConsumableController::class, 'list']);
        Route::prefix('/{id}')->group(function () {
            Route::get('/', [ConsumableController::class, 'index']);
            Route::get('/edit', [ConsumableController::class, 'edit']);
            Route::delete('/', [ConsumableController::class, 'destroy']);
            Route::get('/applications', [ConsumableController::class, 'indexApplications']);
            Route::get('/purchases', [ConsumableController::class, 'indexPurchases']);
            Route::get('/approvers', [ConsumableController::class, 'indexApprovers']);
        });
        Route::middleware(EnsureUserInGroup::class)->group(function () {
            Route::post('/', [ConsumableController::class, 'store']);
        });
    });

    Route::prefix('/consumable_applications')->group(function () {
        Route::get('/', [ConsumableApplicationController::class, 'list']);
        Route::post('/', [ConsumableApplicationController::class, 'store']);
        Route::get('/{id}', [ConsumableApplicationController::class, 'index']);
        Route::get('/{id}/edit', [ConsumableApplicationController::class, 'edit']);
        Route::put('/{id}', [ConsumableApplicationController::class, 'update']);
        Route::delete('/{id}', [ConsumableApplicationController::class, 'destroy']);
    });

    Route::prefix('/consumable_purchases')->group(function () {
        Route::get('/', [ConsumablePurchaseController::class, 'list']);
        Route::post('/', [ConsumablePurchaseController::class, 'store']);
        Route::get('/{id}', [ConsumablePurchaseController::class, 'index']);
        Route::delete('/{id}', [ConsumableApplicationController::class, 'destroy']);
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
