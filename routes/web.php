<?php

use App\Http\Controllers\Api\PracticeController as ApiPracticeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\Auth\VKLoginController;
use App\Http\Controllers\ExtraTokenController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SettingsController;
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

    Route::middleware('role:admin')->group(function () {
        Route::get('/practice/my', [PracticeController::class, 'my'])->name('practice.my');
        Route::get('/practice/{id}/publish', [PracticeController::class, 'publish'])->name('practice.publish');
        Route::resource('practice', PracticeController::class);
    });

    Route::middleware('role:admin')->prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/extra-token', [ExtraTokenController::class, 'index'])->name('extra-token.index');
        Route::post('/extra-token', [ExtraTokenController::class, 'store'])->name('extra-token.store');
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::resource('groups', GroupController::class);
    });
});

Route::prefix('internal')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/practice/test', [ApiPracticeController::class, 'test']);
        Route::post('/practice/{id}/publish', [ApiPracticeController::class, 'publish'])->name('internal.practice.publish');
    });
});
