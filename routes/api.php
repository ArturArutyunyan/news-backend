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
Route::post('/auth/google', [SocialController::class, 'googleRedirect']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['prefix'=>'user'], function(){
        Route::get('/', [UserController::class, 'getUser']);
        Route::post('/', [UserController::class, 'updateUser']);
        Route::get('/{id}', [UserController::class, 'getUserById']);
    });
    Route::post('/posts', [NewsController::class, 'addPost']);
});

