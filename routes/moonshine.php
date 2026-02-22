<?php

use Illuminate\Support\Facades\Route;
use MoonShine\Http\Controllers\HomeController;
use MoonShine\Http\Controllers\AuthenticateController;
use MoonShine\Http\Controllers\ProfileController;

Route::group([
    'middleware' => config('moonshine.route.middleware'),
    'prefix' => config('moonshine.route.prefix'),
    'as' => 'moonshine.'
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('login', [AuthenticateController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthenticateController::class, 'login']);
    Route::post('logout', [AuthenticateController::class, 'logout'])->name('logout');
    
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});