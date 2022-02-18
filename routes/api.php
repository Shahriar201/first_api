<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'AuthController@login')->name('auth-login');
    Route::post('logout', 'AuthController@logout')->name('auth-logout');
    Route::post('refresh', 'AuthController@refresh')->name('auth-refresh');
    Route::post('me', 'AuthController@me')->name('auth-me');
    Route::post('payload', 'AuthController@payload')->name('auth-payload');
    Route::post('register', 'AuthController@register')->name('auth-register');

});
