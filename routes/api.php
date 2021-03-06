<?php

use App\User;
use Illuminate\Http\Request;

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

Route::group([
    'prefix' => 'auth',
    'middleware' => 'api'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('users/me', 'UserController@me');
    Route::post('users/{user}/sync_roles', 'UserController@syncRoles');
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
});
