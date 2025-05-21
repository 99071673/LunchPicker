<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LunchItemController;

Route::get('/', [TimerController::class, 'home'])->name('home');;

Route::get('/userprofile', function () {
    return view('userprofile');
})->name('userprofile');

Route::get('/bestellen/{location_id}', [OrderController::class, 'show'])->name('bestelling');

Route::get('/lunchitems/create', [LunchItemController::class, 'create'])->name('lunchitems.create');
Route::post('/lunchitems', [LunchItemController::class, 'store'])->name('lunchitems.store');

Route::post('/order/add', [OrderController::class, 'add'])->name('order.add');
Route::post('/order/update', [OrderController::class, 'update'])->name('order.update');
Route::post('/order/remove', [OrderController::class, 'remove'])->name('order.remove');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::resource('locations', LocationController::class);
Route::post('locations/submit', [LocationController::class, 'submit'])->name('locations.submit');

require __DIR__.'/auth.php';