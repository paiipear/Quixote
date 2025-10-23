<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BusRouteController;
use App\Http\Controllers\ScheduleController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('search');


// Profile Breeze (sudah otomatis dari Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Passenger Dashboard
Route::middleware(['auth', 'role:passenger'])->group(function () {
    Route::get('/dashboard', [PassengerController::class, 'index'])->name('passenger.dashboard');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
});

// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    //BUSS
    Route::get('/bus', [BusController::class, 'index'])->name('bus.index');
    Route::get('/bus/create', [BusController::class, 'create'])->name('bus.create');
    Route::post('/bus', [BusController::class, 'store'])->name('bus.store');
    Route::get('/bus/{bus}/edit', [BusController::class, 'edit'])->name('bus.edit');
    Route::put('/bus/{bus}', [BusController::class, 'update'])->name('bus.update');
    Route::delete('/bus/{bus}', [BusController::class, 'destroy'])->name('bus.destroy');
   // Rute Bus
    Route::get('/busroute', [BusRouteController::class, 'index'])->name('busroute.index');
    Route::get('/busroute/create', [BusRouteController::class, 'create'])->name('busroute.create');
    Route::post('/busroute', [BusRouteController::class, 'store'])->name('busroute.store');
    Route::get('/busroute/{busroute}/edit', [BusRouteController::class, 'edit'])->name('busroute.edit');
    Route::put('/busroute/{busroute}', [BusRouteController::class, 'update'])->name('busroute.update');
    Route::delete('/busroute/{busroute}', [BusRouteController::class, 'destroy'])->name('busroute.destroy');
   // Schedule Bus
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');


});

Route::get('/check-auth', function () {
    return [
        'auth' => Auth::check(),
        'user' => Auth::user(),
    ];
});



require __DIR__.'/auth.php';