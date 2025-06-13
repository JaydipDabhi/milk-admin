<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MilkDeliveryController;
use App\Http\Controllers\MonthlyReportsController;
use App\Http\Controllers\RateMasterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('admin.index');
Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
Route::post('/register', [AdminController::class, 'store'])->name('admin.store');
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'loginuser'])->name('admin.loginuser');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// User create
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

// Milk Delivery
Route::prefix('milk-delivery')->name('admin.')->group(function () {
    Route::get('/create', [MilkDeliveryController::class, 'milk_delivery'])->name('milk_delivery');
    Route::get('/get-customer-info', [MilkDeliveryController::class, 'getCustomerInfo'])->name('get.customer.info');
    Route::post('/store', [MilkDeliveryController::class, 'milk_delivery_store'])->name('admin.milk_delivery_store');
    Route::get('/list', [MilkDeliveryController::class, 'milk_delivery_list'])->name('milk_delivery_list');
    Route::get('/edit/{id}', [MilkDeliveryController::class, 'milk_delivery_edit'])->name('milk_delivery_edit');
    Route::put('/update/{id}', [MilkDeliveryController::class, 'milk_delivery_update'])->name('milk_delivery_update');
    Route::delete('/delete/{id}', [MilkDeliveryController::class, 'milk_delivery_delete'])->name('milk_delivery_delete');
});

// Rate Master
Route::prefix('rate')->name('admin.')->group(function () {
    Route::get('/create', [RateMasterController::class, 'add_rate'])->name('add_rate');
    Route::post('/store', [RateMasterController::class, 'rate_store'])->name('rate_store');
    Route::get('/list', [RateMasterController::class, 'rate_list'])->name('rate_list');
    Route::get('/edit/{id}', [RateMasterController::class, 'rate_edit'])->name('rate_edit');
    Route::put('/update/{id}', [RateMasterController::class, 'rate_update'])->name('rate_update');
    Route::delete('/delete/{id}', [RateMasterController::class, 'rate_delete'])->name('rate_delete');
});


Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/monthly', [MonthlyReportsController::class, 'showForm'])->name('monthly');
    Route::get('/monthly/generate', [MonthlyReportsController::class, 'generateReport'])->name('monthly.generate');
});
