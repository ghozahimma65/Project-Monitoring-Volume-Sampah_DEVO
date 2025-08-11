<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorApiController;
use App\Http\Controllers\Api\NotificationController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sensor-data', [SensorApiController::class, 'store']);
Route::get('/sensor-data', [SensorApiController::class, 'index']);

Route::get('/latest-volume', [SensorApiController::class, 'getLatestVolume']);


// routes/web.php atau routes/api.php


// Routes untuk notifikasi tanpa database
Route::prefix('api/notifications')->group(function () {
    Route::get('/critical', [NotificationController::class, 'getCriticalNotifications']);
    Route::get('/count', [NotificationController::class, 'getNotificationCount']);
});