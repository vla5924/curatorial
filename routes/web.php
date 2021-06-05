<?php

use App\Http\Controllers\Api\BlockerController;
use App\Http\Controllers\Api\PracticeController as ApiPracticeController;
use App\Http\Controllers\Api\GroupController as ApiGroupController;
use App\Http\Controllers\Api\PointsController as ApiPointsController;
use App\Http\Controllers\Api\PollbunchController as ApiPollbunchController;
use App\Http\Controllers\Api\PostController as ApiPostController;
use App\Http\Controllers\Api\RepublisherController;
use App\Http\Controllers\Api\RoleController as ApiRoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\Auth\VKLoginController;
use App\Http\Controllers\ExtraTokenController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PollbunchController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileInformationController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\VkWebhookController;
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

Route::post('/vk/webhook', [VkWebhookController::class, 'index']);

Route::middleware('guest')->group(function () {
    Route::get('/vk/redirect', [VKLoginController::class, 'redirect'])->name('login.vk.redirect');
    Route::get('/vk/callback', [VKLoginController::class, 'callback'])->name('login.vk.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::middleware('can:view rating')->get('/users/rating', [RatingController::class, 'index'])->name('users.rating.index');
    Route::middleware('can:view rating')->get('/users/rating/{id}', [RatingController::class, 'group'])->name('users.rating.group');
    Route::middleware('can:view profiles')->resource('users', ProfileController::class)->only('show');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/extra-token', [ExtraTokenController::class, 'index'])->name('extra-token.index');
        Route::post('/extra-token', [ExtraTokenController::class, 'store'])->name('extra-token.store');
        Route::get('/information', [ProfileInformationController::class, 'index'])->name('information.index');
        Route::post('/information', [ProfileInformationController::class, 'store'])->name('information.store');
    });

    Route::prefix('help')->group(function () {
        Route::get('/', [HelpController::class, 'index'])->name('help.index');
        Route::get('/about', [HelpController::class, 'about'])->name('help.about');
    });

    Route::middleware('can:view posts')->resource('posts', PostController::class)->only('index');

    Route::middleware('can:publish practices')->get('/practice/{id}/publish', [PracticeController::class, 'publish'])->name('practice.publish');
    Route::middleware('can:create practices')->resource('practice', PracticeController::class)->only(['create', 'store']);
    Route::middleware('can:view practices')->group(function () {
        Route::get('/practice/my', [PracticeController::class, 'my'])->name('practice.my');
        Route::resource('practice', PracticeController::class)->only(['index', 'show']);
    });
    Route::middleware('can:edit practices')->resource('practice', PracticeController::class)->only(['edit', 'update']);
    Route::middleware('can:delete practices')->resource('practice', PracticeController::class)->only('destroy');

    Route::middleware('can:publish pollbunches')->get('/pollbunches/{id}/publish', [PollbunchController::class, 'publish'])->name('pollbunches.publish');
    Route::middleware('can:create pollbunches')->resource('pollbunches', PollbunchController::class)->only(['create', 'store']);
    Route::middleware('can:view pollbunches')->group(function () {
        Route::get('/pollbunches/my', [PollbunchController::class, 'my'])->name('pollbunches.my');
        Route::resource('pollbunches', PollbunchController::class)->only(['index', 'show']);
    });
    Route::middleware('can:edit pollbunches')->resource('pollbunches', PollbunchController::class)->only(['edit', 'update']);
    Route::middleware('can:delete pollbunches')->resource('pollbunches', PollbunchController::class)->only('destroy');

    Route::prefix('internal')->group(function () {
        Route::middleware('can:publish practices')->post('/practice/{id}/publish', [ApiPracticeController::class, 'publish'])->name('internal.practice.publish');
        Route::middleware('can:publish pollbunches')->post('/pollbunches/{id}/publish', [ApiPollbunchController::class, 'publish'])->name('internal.pollbunches.publish');
        Route::middleware('can:assign groups')->post('/groups/assign', [ApiGroupController::class, 'assign'])->name('internal.groups.assign');
        Route::middleware('can:assign roles')->post('/roles/assign', [ApiRoleController::class, 'assign'])->name('internal.roles.assign');
        Route::middleware('can:edit points')->post('/posts/points', [ApiPostController::class, 'points'])->name('internal.posts.points');
        Route::middleware('can:adjust points')->post('/points/adjust', [ApiPointsController::class, 'adjust'])->name('internal.points.adjust');
        Route::middleware('can:nullify points')->post('/points/nullify', [ApiPointsController::class, 'nullify'])->name('internal.points.nullify');
        Route::middleware('can:use blocker')->group(function () {
            Route::post('/blocker/ban', [BlockerController::class, 'ban'])->name('internal.blocker.ban');
            Route::post('/blocker/unban', [BlockerController::class, 'unban'])->name('internal.blocker.unban');
        });
        Route::middleware('can:use republisher')->post('/republisher/publish', [RepublisherController::class, 'publish'])->name('internal.republisher.publish');
    });

    Route::middleware('can:assign groups')->get('/groups/assign', [GroupController::class, 'assign'])->name('groups.assign');
    Route::middleware('can:view groups')->resource('groups', GroupController::class)->only('index');
    Route::middleware('can:create groups')->resource('groups', GroupController::class)->only(['create', 'store']);
    Route::middleware('can:edit groups')->resource('groups', GroupController::class)->only(['edit', 'update']);
    Route::middleware('can:delete groups')->resource('groups', GroupController::class)->only('destroy');

    Route::middleware('can:assign roles')->get('/roles/assign', [RoleController::class, 'assign'])->name('roles.assign');

    Route::middleware('can:use blocker')->get('/tools/blocker', [ToolsController::class, 'blocker'])->name('tools.blocker');
    Route::middleware('can:use republisher')->get('/tools/republisher', [ToolsController::class, 'republisher'])->name('tools.republisher');

    Route::middleware('can:adjust points')->get('/points/adjust', [PointsController::class, 'adjust'])->name('points.adjust');
    Route::middleware('can:nullify points')->get('/points/nullify', [PointsController::class, 'nullify'])->name('points.nullify');
});
