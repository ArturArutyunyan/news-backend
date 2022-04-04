<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/posts', [NewsController::class, 'getAllPosts']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:api')->get('/user', [UserController::class, 'getUser']);
Route::middleware('auth:api')->post('/user', [UserController::class, 'updateUser']);
Route::middleware('auth:api')->get('/users/{id}', [UserController::class, 'getOtherUser']);
Route::middleware('auth:api')->post('/posts', [NewsController::class, 'addPost']);
Route::middleware('auth:api')->post('/auth/google', [SocialController::class, 'googleRedirect']);
