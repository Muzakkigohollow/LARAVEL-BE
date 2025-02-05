<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('product', [ProductController::class, 'index']);
Route::post('register', [AuthController::class, 'register']);
Route::post('auth', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum'

], function(){

    Route::apiResource('category', CategoryController::class);
    Route::post('/product-update/{id}', [ProductController::class,"update"]);

    Route::post('product', [ProductController::class, 'store']);
    Route::put('product{/id}', [ProductController::class, 'update']);
    Route::delete('product{/id}', [ProductController::class, 'destroy']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
