<?php

use App\Http\Controllers\API\CreativeDesign\CreativeDesignApiController;
use App\Http\Controllers\API\Finance\FinanceApiController;
use App\Http\Controllers\API\Journaling\JournalingApiController;
use App\Livewire\Auth\LoginComponent;
use App\Livewire\CMS\Home\BannerIndex;
use App\Livewire\Dashboard\FashionComponent;
use App\Livewire\Dashboard\Overview;
use Illuminate\Support\Facades\Route;

Route::get('/', LoginComponent::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::get('/share/finance/{user_id}/{finance_id}', [FinanceApiController::class, 'view'])
    ->name('finance.share.view');

Route::get('/share/journal/{user_id}/{journal_id}', [JournalingApiController::class, 'view'])
    ->name('journal.share.view');

Route::get('/share/creative-design/{user_id}/{design_id}', [CreativeDesignApiController::class, 'view'])
    ->name('creative.share.view');

Route::get('dashboard', Overview::class)->name('dashboard');

// cms routes
Route::get('home/banner', BannerIndex::class)->name('home.banner.index');
// fashion routes
Route::get('fashions', FashionComponent::class)->name('fashions');

require __DIR__.'/api.php';
