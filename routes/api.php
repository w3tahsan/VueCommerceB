<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('customer/info', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('customer/register', [CustomerController::class, 'register']);
Route::post('customer/login', [CustomerController::class, 'login']);
Route::post('customer/logout', [CustomerController::class, 'logout']);
Route::post('customer/update/{id}', [CustomerController::class, 'customer_update']);


//Category
Route::get('all/category', [CategoryController::class, 'all_category']);

//product
Route::get('all/product', [ProductController::class, 'product']);
Route::get('new/product', [ProductController::class, 'new_product']);
Route::get('product/details/{id}', [ProductController::class, 'product_details']);
