<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MilkCollectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('admin.index');
Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
Route::post('/register', [AdminController::class, 'store'])->name('admin.store');
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'loginuser'])->name('admin.loginuser');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// User create
// Route::get('/user-list', [AdminController::class, 'user_list'])->name('admin.user_list');
// Route::get('/users/create', [AdminController::class, 'user_create'])->name('admin.user_create');
// Route::post('/users/store', [AdminController::class, 'user_store'])->name('admin.user_store');
// Route::get('/users/edit/{id}', [AdminController::class, 'user_edit'])->name('admin.user_edit');
// Route::post('/users/update/{id}', [AdminController::class, 'user_update'])->name('admin.user_update');
// Route::delete('/users/delete/{id}', [AdminController::class, 'user_delete'])->name('admin.user_delete');
Route::prefix('users')->name('admin.')->group(function () {
    Route::get('/list', [AdminController::class, 'user_list'])->name('user_list');
    Route::get('/create', [AdminController::class, 'user_create'])->name('user_create');
    Route::post('/store', [AdminController::class, 'user_store'])->name('user_store');
    Route::get('/edit/{id}', [AdminController::class, 'user_edit'])->name('user_edit');
    Route::post('/update/{id}', [AdminController::class, 'user_update'])->name('user_update');
    Route::delete('/delete/{id}', [AdminController::class, 'user_delete'])->name('user_delete');
});

// Coustomer List
Route::prefix('customer')->name('admin.')->group(function () {
    Route::get('/list', [CustomerController::class, 'customer_list'])->name('customer_list');
    Route::get('/create', [CustomerController::class, 'customer_create'])->name('customer_create');
    Route::post('/store', [CustomerController::class, 'customer_store'])->name('customer_store');
    Route::get('/edit/{id}', [CustomerController::class, 'customer_edit'])->name('customer_edit');
    Route::put('/update/{id}', [CustomerController::class, 'customer_update'])->name('customer_update');
    Route::delete('/delete/{id}', [CustomerController::class, 'customer_delete'])->name('customer_delete');
});

// Milk Collection
