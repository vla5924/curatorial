<?php

use App\Http\Controllers\PracticeController;
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

Route::get('/', [PracticeController::class, 'all']);

Route::get('/practices', [PracticeController::class, 'all']);
Route::get('/practices/{group_alias}', [PracticeController::class, 'byGroup'])->name('practicesByGroup');
Route::get('/practice/{id}', [PracticeController::class, 'single'])->name('singlePractice');
