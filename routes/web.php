<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::view('/', 'guest');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login-proses', [LoginController::class, 'login'])->name('login-proses');
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
});



Route::post('/dashboard/categories/store', [CategoryController::class, 'store'])->name('category.store');
Route::delete('/dashboard/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/dashboard/categories/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/dashboard/categories/update/{id}', [CategoryController::class, 'update'])->name('category.update');

Route::post('/dashboard/transactions/store', [TransactionController::class, 'store'])->name('transaction.store');
Route::delete('/dashboard/transactions/delete/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');
Route::get('/dashboard/transactions/edit/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
Route::put('/dashboard/transactions/update/{id}', [TransactionController::class, 'update'])->name('transaction.update');
Route::get('/dashboard/transactions/report/download', [TransactionController::class, 'downloadReport'])->name('transaction.downloadReport');
Route::get('/chartData', [TransactionController::class, 'chartData'])->name('transaction.chartData');

// Route::get('/dashboard', function () {
//     return app(Dashboard::class)->render();
// })->middleware(['auth'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


require __DIR__ . '/auth.php';
