<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('user/register',[UserController::class,'createUser']);
Route::get('user/register/list',[UserController::class,'listRigisterUsers']);
Route::post('user/login',[UserController::class,'userLogin']);
Route::get('user/login/list',[UserController::class,'listLoginUsers']);


//profile routes
Route::get('profile/list',[ProfileController::class,'index']);
Route::post('profile/create',[ProfileController::class,'store']);
Route::get('profile/show/{id}',[ProfileController::class,'show']);
Route::put('profile/update/{id}',[ProfileController::class,'update']);
Route::delete('profile/delete/{id}',[ProfileController::class,'destroy']);
