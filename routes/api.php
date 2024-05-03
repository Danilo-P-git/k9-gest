<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CashFundController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
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


Route::middleware(['security'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::apiResource('categories', CategoryController::class);
    Route::get('allCategories', [CategoryController::class, 'getAll']);
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::delete('transactions/{id}', [TransactionController::class, 'delete']);
    Route::get('users', [AuthController::class, 'getUsers']);
    Route::post('calculate', [CashFundController::class, 'calculate']);
    Route::post('cash_fund', [CashFundController::class, 'store']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
