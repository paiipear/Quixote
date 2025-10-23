<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\BusRouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PassengerController;

// 🌐 Halaman utama & pencarian umum
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('search');

// 🌟 Profile (bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🧍‍♀️ Passenger routes
Route::middleware(['auth', 'role:passenger'])->group(function () {
    Route::get('/dashboard', [PassengerController::class, 'index'])->name('passenger.dashboard');
    Route::get('/dashboard/search', [SearchController::class, 'search'])->name('passenger.search');

    // Reservasi
    Route::get('/reservasi/{schedule_id}', [PassengerController::class, 'showReservationForm'])->name('passenger.reserve.form');
    Route::post('/reservasi/store', [PassengerController::class, 'storeReservation'])->name('passenger.reserve.store');
    Route::get('/reservasi-saya', [PassengerController::class, 'myReservations'])->name('passenger.reservations');
    Route::get('/reservasi/detail/{id}', [PassengerController::class, 'showReservationDetail'])->name('passenger.reservation.detail');
    Route::patch('/reservasi/cancel/{id}', [PassengerController::class, 'cancelReservation'])->name('passenger.reservation.cancel');

    // Pembayaran
    Route::get('/pembayaran/{reservation_id}', [PassengerController::class, 'showPaymentForm'])->name('passenger.payment.form');
    Route::post('/pembayaran/proses/{reservation_id}', [PassengerController::class, 'processPayment'])->name('passenger.payment.process');
    Route::get('/reservasi/download/{id}', [PassengerController::class, 'downloadTicket'])->name('passenger.ticket.download');
});

// 🧰 Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('bus', BusController::class);
    Route::resource('busroute', BusRouteController::class);
    Route::resource('schedule', ScheduleController::class);
    Route::resource('reservation', ReservationController::class);
});

// 🔍 Check auth API (debug)
Route::get('/check-auth', fn() => ['auth' => Auth::check(), 'user' => Auth::user()]);

require __DIR__.'/auth.php';
