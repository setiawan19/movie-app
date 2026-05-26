<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['localization'])->group(function () {
    // Auth Routes
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('lang/{locale}', [LanguageController::class, 'switchLang']);

    // Protected Routes (Harus Login)
    Route::middleware(['custom.auth'])->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('home');
        Route::get('movie/{id}', [MovieController::class, 'detail']);
        Route::get('favorites', [FavoriteController::class, 'index']);
        Route::post('favorites/add', [FavoriteController::class, 'add']);
        Route::delete('favorites/delete/{id}', [FavoriteController::class, 'destroy']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});