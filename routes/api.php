<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\admin\Catalog\BrandController;
use App\Http\Controllers\admin\Catalog\CategoryController;

Route::post('/admin/login', [AuthController::class, 'authenticate']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('brands', BrandController::class)->except(['create', 'edit']);
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::get('sizes', [SizeController::class, 'index'])->name('sizes.index');
    Route::resource('products', ProductController::class)->except(['create', 'edit']);
    Route::post('temp-images', [TempImageController::class, 'store'])->name('temp-images.store');
    Route::get('temp-images/{id}', [TempImageController::class, 'show'])->name('temp-images.show');
    Route::post('save-product-image', [ProductController::class, 'saveProductImage']);
    Route::get('change-product-default-image', [ProductController::class, 'updateDefaultImage']);
    Route::delete('delete-product-image/{id}', [ProductController::class, 'deleteProductImage']);
});


