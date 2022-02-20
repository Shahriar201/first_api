<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['prefix' => 'v1'], function () {

//     Route::post('login', 'AuthController@login')->name('auth.login');
//     Route::post('logout', 'AuthController@logout')->name('auth.logout');
//     //Route::post('refresh', 'AuthController@refresh')->name('auth.refresh');
//     Route::post('me', 'AuthController@me')->name('auth.me');
//     //Route::post('payload', 'AuthController@payload')->name('auth.payload');
//     Route::post('register', 'AuthController@register')->name('auth.register');

//     // Permission Routes
//     Route::prefix('permissions')->group(function() {
//         Route::post('/view', 'PermissionController@view')->name('permissions.view');
//         Route::post('/store', 'PermissionController@store')->name('permissions.store');
//         Route::post('/show/{id}', 'PermissionController@show')->name('permissions.show');
//         Route::post('/update/{id}', 'PermissionController@update')->name('permissions.update');
//         Route::post('/delete/{id}', 'PermissionController@delete')->name('permissions.delete');
//     });
    
//     // Role Routes
//     Route::prefix('roles')->group(function() {
//         Route::post('/view', 'RoleController@view')->name('roles.view');
//         Route::post('/store', 'RoleController@store')->name('roles.store');
//         Route::post('/show/{id}', 'RoleController@show')->name('roles.show');
//         Route::post('/update/{id}', 'RoleController@update')->name('roles.update');
//         Route::post('/delete/{id}', 'RoleController@delete')->name('roles.delete');
//     });
// });


// ========Auth===========
// ========Auth===========
Route::group([
    'prefix' => 'v1'
], function(){
    // Route::post('login', 'AuthController@login')->name('login');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('signup', 'AuthController@signup');
});

// Route::group([
//     'prefix' => 'v1',
//     'middleware' => 'auth:api',
// ], function () {
//     Route::post('me', 'AuthController@me');
//     Route::post('getRolePermissions', 'AuthController@getRolePermissions');
//     Route::post('logout', 'AuthController@logout');

//     Route::post('/changePassword', 'AuthController@changePassword');
//     Route::post('/profileUpdate', 'AuthController@profileUpdate');
// });
// ========Auth===========
// ========Auth===========