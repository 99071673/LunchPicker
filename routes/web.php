<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LunchItemController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/bestellen/{location_id}', [OrderController::class, 'show'])->name('bestelling');
Route::get('/lunchitems/create', [LunchItemController::class, 'create'])->name('lunchitems.create');
Route::post('/lunchitems', [LunchItemController::class, 'store'])->name('lunchitems.store');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
