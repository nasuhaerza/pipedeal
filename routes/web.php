<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PageController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientWebController;
use App\Http\Controllers\CommissionShareController;
use App\Http\Controllers\CommissionShareWebController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DealWebController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentWebController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\FollowUpWebController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\PipelineStageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('login', [PageController::class, 'login'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->middleware('guest');
Route::get('register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest')->name('register.store');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::resource('clients', ClientWebController::class);
        Route::resource('deals', DealWebController::class)->except(['show']);
        Route::get('deals/{deal}', [DealWebController::class, 'show'])->name('deals.show');
        Route::resource('follow-ups', FollowUpWebController::class)->except(['show']);
        Route::get('follow-ups/{follow_up}', [FollowUpWebController::class, 'show'])->name('follow-ups.show');
        Route::resource('documents', DocumentWebController::class)->except(['show']);
        Route::get('documents/{document}', [DocumentWebController::class, 'show'])->name('documents.show');
        Route::resource('commission-shares', CommissionShareWebController::class)->except(['show']);
        Route::get('pipeline', [PipelineController::class, 'index'])->name('pipeline.index');
        Route::patch('pipeline/deals/{deal}/stage', [PipelineController::class, 'updateStage'])->name('pipeline.deals.stage.update');
        Route::get('team/create', [\App\Http\Controllers\TeamMemberController::class, 'create'])->middleware('company-admin')->name('team.create');
        Route::post('team', [\App\Http\Controllers\TeamMemberController::class, 'store'])->middleware('company-admin')->name('team.store');
    });

    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('deals', DealController::class);
    Route::apiResource('commission-shares', CommissionShareController::class);
    Route::apiResource('follow-ups', FollowUpController::class);
    Route::apiResource('documents', DocumentController::class);
    Route::apiResource('pipeline-stages', PipelineStageController::class)->only(['index', 'show']);
    Route::get('activity-logs', [ActivityLogController::class, 'index']);
});
