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

    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('logout', 'AuthController@logout')->name('auth.logout');
    Route::post('refresh', 'AuthController@refresh')->name('auth.refresh');
    Route::post('me', 'AuthController@me')->name('auth.me');
    Route::post('payload', 'AuthController@payload')->name('auth.payload');
    Route::post('register', 'AuthController@register')->name('auth.register');

    // Permission Routes
    Route::prefix('permissions')->group(function() {
        Route::post('/view', 'PermissionController@view')->name('permissions.view');
        Route::post('/store', 'PermissionController@store')->name('permissions.store');
        Route::post('/show/{id}', 'PermissionController@show')->name('permissions.show');
        Route::post('/update/{id}', 'PermissionController@update')->name('permissions.update');
        Route::post('/delete/{id}', 'PermissionController@delete')->name('permissions.delete');
    });
    
    // Role Routes
    Route::prefix('roles')->group(function() {
        Route::post('/view', 'RoleController@view')->name('roles.view');
        Route::post('/store', 'RoleController@store')->name('roles.store');
        Route::post('/show/{id}', 'RoleController@show')->name('roles.show');
        Route::post('/update/{id}', 'RoleController@update')->name('roles.update');
        Route::post('/delete/{id}', 'RoleController@delete')->name('roles.delete');
    });
});
