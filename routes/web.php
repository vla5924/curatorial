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

    Route::middleware('can:publish practices')->get('/practice/{id}/publish', [PracticeController::class, 'publish'])->name('practice.publish');
    Route::middleware('can:view practices')->group(function () {
        Route::get('/practice/my', [PracticeController::class, 'my'])->name('practice.my');
        Route::resource('practice', PracticeController::class)->only(['index', 'show']);
    });
    Route::middleware('can:create practices')->resource('practice', PracticeController::class)->only(['create', 'store']);
    Route::middleware('can:edit practices')->resource('practice', PracticeController::class)->only(['edit', 'update']);
    Route::middleware('can:delete practices')->resource('practice', PracticeController::class)->only('destroy');

    Route::middleware('role:admin')->prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/extra-token', [ExtraTokenController::class, 'index'])->name('extra-token.index');
        Route::post('/extra-token', [ExtraTokenController::class, 'store'])->name('extra-token.store');
    });

    Route::middleware('can:view groups')->resource('groups', GroupController::class)->only('index');
    Route::middleware('can:create groups')->resource('groups', GroupController::class)->only(['create', 'store']);
    Route::middleware('can:edit groups')->resource('groups', GroupController::class)->only(['edit', 'update']);
    Route::middleware('can:delete groups')->resource('groups', GroupController::class)->only('destroy');

    Route::prefix('internal')->group(function () {
        Route::middleware('role:admin')->group(function () {
            Route::get('/practice/test', [ApiPracticeController::class, 'test']);
        });

        Route::middleware('can:publish practices')->post('/practice/{id}/publish', [ApiPracticeController::class, 'publish'])->name('internal.practice.publish');
    });
});
