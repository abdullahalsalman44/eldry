<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FamilyController;
use App\Http\Controllers\CareGiverController;
use App\Http\Controllers\ElderlyPersonController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserHasRole;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);


    Route::prefix('family')->group(function () {
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
        Route::post('create', [CareGiverController::class, 'create'])->middleware(['role:admin']);
        Route::post('update', [CareGiverController::class, 'update'])->middleware(['role:caregiver|admin']);
        Route::get('get_eldries', [CareGiverController::class, 'getListOfEldries']);
    });

    Route::prefix('eldery')->group(function () {
        Route::get('index', [ElderlyPersonController::class, 'index']);
        Route::post('eldery/create', [ElderlyPersonController::class, 'create'])->middleware(['role:admin']);
        Route::get('show/{id}', [ElderlyPersonController::class, 'show']);
        Route::post('update/{id}', [ElderlyPersonController::class, 'update'])->middleware(['role:admin']);
    });

    Route::resource('rate', RateController::class)->only('index');
});

Route::middleware(['guest'])->group(function () {
    Route::prefix('event')->group(function () {
        Route::get('index', [EventController::class, 'index']);
        Route::get('show/{id}', [EventController::class, 'show']);
    });

    Route::resource('employee', EmployeeController::class)->only('index');

    Route::resource('rate', RateController::class);
});
