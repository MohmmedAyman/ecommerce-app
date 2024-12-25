<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Maincategoryv2Controller;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\searchController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\Api\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('token/create',function(Request $request){
//     $token = $request->user()->createToken($request->token_name);

//     return ['token'=>$token->plainTextToken];
// });

Route::post('/user/register',[UserController::class,'createuser']);
Route::post('/user/login',[UserController::class,'login']);
Route::post('/user/socialite/login',[SocialiteController::class,'login']);

Route::group([
    'middleware' => 'auth:sanctum'
],function(){
    Route::apiResource('maincategory',Maincategoryv2Controller::class);
    Route::apiResource('category',CategoryController::class);
    Route::apiResource('product',ProductController::class);
    Route::apiResource('brand',BrandController::class);
    Route::get('/search',[searchController::class,'productsearch']);
    Route::get('/userprofile',[UserController::class,'me']);
    Route::post('/user/logout',[UserController::class,'logout']);
});