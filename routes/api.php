<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FamilyController;
use App\Http\Controllers\CareGiverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserHasRole;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->prefix('family')->group(function () {
    Route::get('/my-elderly', [FamilyController::class, 'myElderly']);
    Route::get('/elderly/{id}/daily-reports', [FamilyController::class, 'showDailyReports']);
    Route::post('/inquiries', [FamilyController::class, 'sendInquiry']);
    Route::get('/myinquiries', [FamilyController::class, 'myInquiries']);
    Route::get('/notifications', [FamilyController::class, 'myNotifications']);
    Route::get('/profile', [FamilyController::class, 'profile']);
    Route::put('/updateprofile', [FamilyController::class, 'updateProfile']);
    Route::post('/profile/change-password', [FamilyController::class, 'changePassword']);
});

Route::prefix('caregiver')->group(function () {
    Route::post('create', [CareGiverController::class, 'create']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::put('update', [CareGiverController::class, 'update'])->middleware(['role:caregiver']);
        Route::get('get_eldries', [CareGiverController::class, 'getListOfEldries']);
    });
});
