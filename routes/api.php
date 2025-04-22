<?php

use App\Http\Controllers\API\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('customer/info', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('customer/register', [CustomerController::class, 'register']);
Route::post('customer/login', [CustomerController::class, 'login']);
Route::post('customer/logout', [CustomerController::class, 'logout']);
Route::post('customer/update/{id}', [CustomerController::class, 'customer_update']);

