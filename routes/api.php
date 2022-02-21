<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
  Route::post('posts', [PostController::class, 'store']);
});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {
  Route::apiResource('projects', ProjectController::class);
});

Route::group(['middleware' => 'api', 'prefix' => 'v1/auth'], function () {
  Route::post('login', [AuthController::class, 'login'])->name('api.login');
  Route::post('register', [AuthController::class, 'register'])->name('api.register');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
