<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('api.logout');

    Route::get('/products', [App\Http\Controllers\ProductController::class, 'filterProducts'])->name('api.products');
    Route::get('/filters', [App\Http\Controllers\ProductController::class, 'getDataForFilters'])->name('api.filters');
    Route::get('/brands', [App\Http\Controllers\BrandController::class, 'index'])->name('api.brands');
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('api.categories');
    Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->name('api.suppliers');
});
