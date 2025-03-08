<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrganizationController;

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
Route::middleware("custom_api_auth")->group(function(){
    Route::controller(OrganizationController::class)
    ->group(function () {
        Route::post('/create', 'create');
    });

    Route::controller(ServiceController::class)
    ->group(function () {
        Route::get('/services/{organization_id}', 'index');
        Route::post('/services/create', 'create');
        Route::get('/services/show/{service_id}', 'show');
        Route::put('/services/update/{service_id}', 'update');
        Route::delete('/services/delete/{service_id}', 'delete');
    });
});
