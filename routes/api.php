<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;

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

Route::post('/login',[LoginController::class,'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group([
        'prefix' => 'products',
        'as' => 'products.',
    ],function() {
        Route::get('/',[ProductController::class,'index']);
        Route::get('/dropdown',[ProductController::class,'dropdown']);
        Route::post('/',[ProductController::class,'store']);
        Route::match(['put','patch'],'/{product}',[ProductController::class,'update']);
        Route::get('/{product}',[ProductController::class,'show']);
        Route::delete('/{product}',[ProductController::class,'destroy']);
    });
});

Route::middleware('auth:sanctum')
    ->group(function(){

    });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
