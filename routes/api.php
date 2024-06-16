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


Route::post('user/login',[UserController::class,'userLogin']);
//forgot password
Route::post('user/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('user/reset-password', [UserController::class, 'resetPassword']);
Route::middleware("auth:sanctum")->group(function(){
  
    
    //profile user
    Route::get('profile', [ProfileController::class, 'show']);
    Route::post('profile/upload-image', [ProfileController::class, 'uploadImage']); // This may be redundant with update
    Route::put('profile/edit', [ProfileController::class, 'update']);
    

    
    //    start post user router 
    Route::delete('post/delete/{id}', [postcontroller::class,'destroy']);
    Route::post('/add-post', [postcontroller::class, 'addPost']);
    Route::put('post/update/{id}', [postcontroller::class,'update']);
    Route::get('post/list', [postcontroller::class, 'index']);
    // end post user router

    //start comment user router
    Route::post('comment/create', [commentcontroller::class, 'store']);
    Route::put('comment/update/{id}', [commentcontroller::class, 'update']);
    Route::delete('comment/delete/{id}', [commentcontroller::class, 'destroy']);
    // end comment user router

    //start reaction user router
    Route::post('reaction/craete', [reactioncontroller::class, 'store']);
    //profile
    Route::put('reaction/update/{id}', [reactioncontroller::class, 'update']);
    Route::delete('reaction/delete/{id}', [reactioncontroller::class, 'destroy']);
    // end reaction user router

    //profile routes
    Route::post('profile/create',[ProfileController::class,'store']);
    Route::get('profile/show/{id}',[ProfileController::class,'show']);
    Route::put('profile/update/{id}',[ProfileController::class,'update']);
    Route::delete('profile/delete/{id}',[ProfileController::class,'destroy']);
    Route::get('profile/list',[ProfileController::class,'index']);
    //friend 
    Route::post('/friends', [FriendRequestController::class, 'store']);
    Route::put('/friends/{id}', [FriendRequestController::class, 'update']);
    Route::delete('/friends/{id}', [FriendRequestController::class, 'destroy']);
    Route::get('/friends/list', [FriendRequestController::class, 'friendsList']);
    //user logout
    Route::post('/logout', [UserController::class,'Logout']);

    
});

