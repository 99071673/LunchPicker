<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home.page');

Route::get('/userprofile', function () {
    return view('userprofile');
})->name('userprofile');

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