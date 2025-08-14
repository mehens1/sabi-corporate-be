<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BLCEventAttendees;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'blc'], function () {
    Route::group(['prefix' => 'attendees'], function () {
        Route::get("/", [BLCEventAttendees::class, 'index']);
    });

    Route::group(['prefix' => 'attendees'], function () {
        Route::post("/", [BLCEventAttendees::class, 'store']);
    });
});
