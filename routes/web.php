<?php

use App\Http\Controllers\Backstage\CampaignsController;
use App\Http\Controllers\Backstage\DashboardController;
use App\Http\Controllers\Backstage\GameController;
use App\Http\Controllers\Backstage\PrizeController;
use App\Http\Controllers\Backstage\UserController;
use App\Http\Controllers\Backstage\SymbolController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::prefix('backstage')->name('backstage.')->middleware(['auth', 'setActiveCampaign'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Campaigns
    Route::get('campaigns/{campaign}/use', [CampaignsController::class, 'use'])->name('campaigns.use');
    Route::resource('campaigns', CampaignsController::class);
    Route::resource('symbols', SymbolController::class);

    Route::group(['middleware' => ['redirectIfNoActiveCampaign']], function () {
        Route::post('games/export', [GameController::class, 'export'])->name('games.export');
        Route::resource('games', GameController::class);
        Route::resource('prizes', PrizeController::class);
    });

    // Users
    Route::resource('users', UserController::class);
});

// Route::prefix('backstage')->middleware('setActiveCampaign')->group(function () {
//     // Account activation
//     Route::get('activate/{ott}', 'Auth\ActivateAccountController@index')->name('backstage.activate.show');
//     Route::put('activate/{ott}', 'Auth\ActivateAccountController@update')->name('backstage.activate.update');
// });

Route::get('{campaign:slug}', [FrontendController::class, 'loadCampaign'])->middleware(['redirectIfNotEnoughSymbols']);
Route::get('/', [FrontendController::class, 'placeholder']);
