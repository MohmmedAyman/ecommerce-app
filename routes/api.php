<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Maincategoryv2Controller;
use App\Http\Controllers\ProductController;
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

Route::group([
    'middleware' => 'auth:sanctum'
],function(){
    Route::apiResource('maincategory',Maincategoryv2Controller::class);
    Route::apiResource('category',CategoryController::class);
    Route::apiResource('product',ProductController::class);
    Route::get('/userprofile',[UserController::class,'me']);
    Route::post('/user/logout',[UserController::class,'logout']);
});