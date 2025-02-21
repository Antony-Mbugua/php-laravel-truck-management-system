<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintenanceTypeController;

//Route::view('/', 'welcome');

Route::get('/', HomePage::class);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    
});

Route::get('/trucks/{id}/download', [TruckController::class, 'downloadTruckPdf'])->name('trucks.download');

Route::get('/trucks/download-all', [TruckController::class, 'downloadAllTrucksPdf'])->name('trucks.download.all');

Route::get('/users/{id}/download', [UserController::class, 'downloadUserPdf'])->name('user.download');

Route::get('/users/download-all', [UserController::class, 'downloadAllUsersPdf'])->name('users.download.all');

Route::resource('maintenance-types', MaintenanceTypeController::class);