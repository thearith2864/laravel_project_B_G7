<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\commentcontroller;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\FriendRequestController;
use App\Http\Controllers\Api\postcontroller;
use App\Http\Controllers\Api\reactioncontroller;
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
//user registration
Route::post('user/register',[UserController::class,'createUser']);
Route::get('user/register/list',[UserController::class,'listRigisterUsers']);

//user login
Route::post('user/login',[UserController::class,'userLogin']);
Route::get('user/login/list',[UserController::class,'listLoginUsers']);
//profile registration
Route::get('profile/list',[ProfileController::class,'index']);
Route::put('profile/update',[ProfileController::class,'store']);

Route::post('user/login',[UserController::class,'userLogin']);
Route::middleware("auth:sanctum")->group(function(){
  
    //post registration
    route::post('post/create', [postcontroller::class, 'store']);
    route::get('post/list', [postcontroller::class, 'index']);
    //profile user
    Route::post('/profiles',[ProfileController::class,'uploadImage']);
    Route::get('/profiles/show',[ProfileController::class,'show']);
    //    start post user router 
    Route::post('post/create', [postcontroller::class, 'store']);
    Route::get('post/list', [postcontroller::class, 'index']);
    Route::put('post/update/{id}', [postcontroller::class,'update']);
    Route::delete('post/delete/{id}', [postcontroller::class,'destroy']);
    // end post user router
    //start comment user router
    Route::post('comment/create', [commentcontroller::class, 'store']);
    Route::post('reaction/craete', [reactioncontroller::class, 'store']);
    //profile
    Route::put('reaction/update/{id}', [reactioncontroller::class, 'update']);
    Route::delete('reaction/delete/{id}', [reactioncontroller::class, 'destroy']);
    // end reaction user router
    //profile routes
    
    Route::put('profile/update/{id}',[ProfileController::class,'update']);
    //friend
    Route::get('/friends', [FriendRequestController::class, 'index']);
    Route::post('/friends', [FriendRequestController::class, 'store']);
    Route::put('/friends/{id}', [FriendRequestController::class, 'update']);
    Route::delete('/friends/{id}', [FriendRequestController::class, 'destroy']);
    Route::get('/friends/{id}', [FriendRequestController::class, 'getFriend']); 
});

//profile routes
Route::get('profile/list',[ProfileController::class,'index']);
Route::post('profile/create',[ProfileController::class,'store']);
Route::get('profile/show/{id}',[ProfileController::class,'show']);
Route::delete('profile/delete/{id}',[ProfileController::class,'destroy']);

// Friendships
Route::get('friend/list', [FriendController::class,'index']);
Route::post('friend/create', [FriendController::class,'store']);
Route::get('friend/show/{id}', [FriendController::class,'show']);
Route::put('friend/update/{id}', [FriendController::class,'update']);
Route::delete('friend/delete/{id}', [FriendController::class,'destroy']);



