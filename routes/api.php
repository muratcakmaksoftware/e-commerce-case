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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'auth'], function(){
    Route::post("register", [AuthController::class, 'register'])->name('auth.register');
    Route::post("login", [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::post("logout", [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::resource("company-packages", CompanyPackageController::class)->only(['store']);

    /*Route::resource("users", UserController::class)->only(['index', 'edit', 'store', 'update', 'destroy']);
    Route::put("users/{user}/restore", [UserController::class, 'restore'])->name('users.restore');
    Route::get("users/datatables", [UserController::class, 'datatables'])->name('users.datatables');
    Route::get("users/trashed-datatables", [UserController::class, 'trashedDatatables'])->name('users.trashed_datatables');*/
});
