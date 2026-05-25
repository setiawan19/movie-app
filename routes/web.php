<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web', 'localization']], function () {
    // Auth Routes
    Route::get('login', 'AuthController@showLogin');
    Route::post('login', 'AuthController@login');
    
    // Language Switcher
    Route::get('lang/{locale}', 'LanguageController@switchLang');

    // Protected Routes (Harus Login)
    Route::group(['middleware' => 'custom.auth'], function () {
        Route::get('/', 'MovieController@index');
        Route::get('movie/{id}', 'MovieController@detail');
        Route::get('favorites', 'FavoriteController@index');
        Route::post('favorites/add', 'FavoriteController@add');
        Route::delete('/favorites/delete/{id}', 'FavoriteController@destroy');
    
        Route::get('logout', 'AuthController@logout');
    });
});