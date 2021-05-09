<?php

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\VKAuthController;
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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/vk/redirect', [VKAuthController::class, 'redirect'])->name('vkAuth');
    Route::get('/vk/callback', [VKAuthController::class, 'callback']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [PracticeController::class, 'all']);
    Route::get('/practices', [PracticeController::class, 'all'])->name('practices');
    Route::get('/practices/{group_alias}', [PracticeController::class, 'byGroup'])->name('practicesByGroup');
    Route::get('/practice/{id}', [PracticeController::class, 'single'])->name('singlePractice');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
