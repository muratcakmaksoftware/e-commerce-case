<?php

use App\Http\Controllers\Backend\Auth\AuthController;
use App\Http\Controllers\Backend\CompanyPackage\CompanyPackageController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'auth'], function(){
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::resource('company-packages', CompanyPackageController::class)->only(['store']);
    Route::get("check-company-packages", [CompanyPackageController::class, 'checkCompanyPackage'])->name('company-packages.check_company_package');

});
