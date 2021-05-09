<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\Auth\VKLoginController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware('guest')->group(function () {
    Route::get('/vk/redirect', [VKLoginController::class, 'redirect'])->name('vkAuth');
    Route::get('/vk/callback', [VKLoginController::class, 'callback']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::middleware('role:user')->group(function () {
        Route::get('/practices', [PracticeController::class, 'all'])->name('practices');
        Route::get('/practices/{group_alias}', [PracticeController::class, 'byGroup'])->name('practicesByGroup');
        Route::get('/practice/{id}', [PracticeController::class, 'single'])->name('singlePractice');
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::resource('groups', GroupController::class);
    });
});
