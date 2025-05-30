<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LunchItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserProfileController;

Route::get('/', [HomepageController::class, 'home'])->name('home');;

Route::middleware(['auth'])->group(function () {
    Route::get('/userprofile', [UserProfileController::class, 'index'])->name('userprofile');
    Route::get('/bestellen/{location_id}', [OrderController::class, 'show'])->name('bestelling');

    Route::get('/lunchitems/create', [LunchItemController::class, 'create'])->name('lunchitems.create');
    Route::get('/lunchitems/edit/{lunchitem_id}', [LunchItemController::class, 'edit'])->name('lunchitems.edit')->middleware('can:access-admin');
    Route::delete('/lunchitems/{lunchitem_id}', [LunchItemController::class, 'destroy'])->name('lunchitems.destroy')->middleware('can:access-admin');
    Route::post('/lunchitems', [LunchItemController::class, 'store'])->name('lunchitems.store');

    Route::post('/order/add', [OrderController::class, 'add'])->name('order.add');
    Route::post('/order/update', [OrderController::class, 'update'])->name('order.update');
    Route::post('/order/remove', [OrderController::class, 'remove'])->name('order.remove');

    Route::resource('locations', LocationController::class);
    Route::post('locations/submit', [LocationController::class, 'submit'])->name('locations.submit');

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])
            ->name('admin')
            ->middleware('can:access-admin');
        Route::get('/admin/location/create', [LocationController::class, 'create'])
            ->name('location.create')
            ->middleware('can:access-admin');;
        Route::post('/admin/location', [LocationController::class, 'store'])
            ->name('location.store')
            ->middleware('can:access-admin');
        Route::get('/admin/location/{location}/edit', [LocationController::class, 'edit'])
            ->name('location.edit')
            ->middleware('can:access-admin');
        Route::put('/locations/{location}', [LocationController::class, 'update'])
            ->name('locations.update')
            ->middleware('can:access-admin');
        Route::delete('/admin/location/{location}', [LocationController::class, 'destroy'])
            ->name('location.destroy')
            ->middleware('can:access-admin');
    });

    Route::view('dashboard', 'dashboard')->middleware('verified')->name('dashboard');

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
