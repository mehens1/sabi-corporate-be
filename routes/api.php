<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BLCEventAttendees;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UsersController;

Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get("/", [UsersController::class, 'index']);
    });


    Route::group(['prefix' => 'blc'], function () {
        Route::group(['prefix' => 'attendees'], function () {
            Route::get("/", [BLCEventAttendees::class, 'index']);
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::post("/status", [PaymentController::class, 'status']);
            Route::post("/notification", [PaymentController::class, 'notification']);
        });
    });
});

Route::group(['prefix' => 'auth'], function () {
    Route::post("/login", [AuthController::class, 'login']);
});

Route::group(['prefix' => 'blc'], function () {
    Route::group(['prefix' => 'attendees'], function () {
        Route::get("/{id}", [BLCEventAttendees::class, 'show']);
        Route::post("/", [BLCEventAttendees::class, 'store']);
    });
});
