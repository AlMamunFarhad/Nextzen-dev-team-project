<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('index');
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('user/dashboard', [DashboardController::class, 'userdashboard'])->middleware('auth', 'user')->name('dashboard');
Route::get('seller/dashboard', [DashboardController::class, 'sellerdashboard'])->middleware('auth', 'seller')->name('seller.dashboard');
Route::get('admin/dashboard', [DashboardController::class, 'admindashboard'])->middleware('auth', 'admin')->name('admin.dashboard');
