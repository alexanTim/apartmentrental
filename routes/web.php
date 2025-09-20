<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SliderController;

Route::get('/', [BookingController::class, 'mainpage'])->name('mainpage');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::resource('tenants', TenantController::class);
Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);
Route::resource('expenses', ExpenseController::class);
Route::get('/reports/expenses', [ReportController::class, 'expenses'])->name('reports.expenses');
Route::post('/bookings/abandoned', [BookingController::class, 'saveAbandoned'])
    ->name('bookings.abandoned');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('sliders', SliderController::class)->except(['show', 'edit', 'create']);   
    Route::post('/sliders/order', [SliderController::class, 'updateOrder'])->name('sliders.order');
    Route::post('/sliders/{slider}/image', [SliderController::class, 'updateImage'])->name('sliders.updateImage');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
