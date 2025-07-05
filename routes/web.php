<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MilkDairyController;
use App\Http\Controllers\RateMasterController;
use App\Http\Controllers\MilkDeliveryController;
use App\Http\Controllers\MonthlyReportsController;

/*
|--------------------------------------------------------------------------
| Public Routes (no auth)
|--------------------------------------------------------------------------
*/

Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
Route::post('/register', [AdminController::class, 'store'])->name('admin.store');

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'loginuser'])->name('admin.loginuser');

Route::get('/forgot-password', [AdminController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AdminController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AdminController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AdminController::class, 'reset'])->name('password.update');
Route::get('/reset-password-form', [AdminController::class, 'showCustomResetForm'])->name('password.custom.form');

/*
|--------------------------------------------------------------------------
| Protected Routes (auth middleware)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    /*
    |--------------------------------------------------------------------------
    | Users (Admin Users)
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')->name('admin.')->group(function () {
        Route::get('/list', [AdminController::class, 'user_list'])->name('user_list');
        Route::get('/create', [AdminController::class, 'user_create'])->name('user_create');
        Route::post('/store', [AdminController::class, 'user_store'])->name('user_store');
        Route::get('/edit/{id}', [AdminController::class, 'user_edit'])->name('user_edit');
        Route::post('/update/{id}', [AdminController::class, 'user_update'])->name('user_update');
        Route::delete('/delete/{id}', [AdminController::class, 'user_delete'])->name('user_delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */
    Route::prefix('customer')->name('admin.')->group(function () {
        Route::get('/list', [CustomerController::class, 'customer_list'])->name('customer_list');
        Route::get('/create', [CustomerController::class, 'customer_create'])->name('customer_create');
        Route::post('/store', [CustomerController::class, 'customer_store'])->name('customer_store');
        Route::get('/edit/{id}', [CustomerController::class, 'customer_edit'])->name('customer_edit');
        Route::put('/update/{id}', [CustomerController::class, 'customer_update'])->name('customer_update');
        Route::delete('/delete/{id}', [CustomerController::class, 'customer_delete'])->name('customer_delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Milk Delivery
    |--------------------------------------------------------------------------
    */
    Route::prefix('milk-delivery')->name('admin.')->group(function () {
        Route::get('/create', [MilkDeliveryController::class, 'milk_delivery'])->name('milk_delivery');
        Route::get('/get-customer-info', [MilkDeliveryController::class, 'getCustomerInfo'])->name('get.customer.info');
        Route::post('/store', [MilkDeliveryController::class, 'milk_delivery_store'])->name('milk_delivery_store');
        Route::get('/list', [MilkDeliveryController::class, 'milk_delivery_list'])->name('milk_delivery_list');
        Route::get('/edit/{id}', [MilkDeliveryController::class, 'milk_delivery_edit'])->name('milk_delivery_edit');
        Route::put('/update/{id}', [MilkDeliveryController::class, 'milk_delivery_update'])->name('milk_delivery_update');
        Route::delete('/delete/{id}', [MilkDeliveryController::class, 'milk_delivery_delete'])->name('milk_delivery_delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Rate Master
    |--------------------------------------------------------------------------
    */
    Route::prefix('rate')->name('admin.')->group(function () {
        Route::get('/create', [RateMasterController::class, 'add_rate'])->name('add_rate');
        Route::post('/store', [RateMasterController::class, 'rate_store'])->name('rate_store');
        Route::get('/list', [RateMasterController::class, 'rate_list'])->name('rate_list');
        Route::get('/edit/{id}', [RateMasterController::class, 'rate_edit'])->name('rate_edit');
        Route::put('/update/{id}', [RateMasterController::class, 'rate_update'])->name('rate_update');
        Route::delete('/delete/{id}', [RateMasterController::class, 'rate_delete'])->name('rate_delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/monthly', [MonthlyReportsController::class, 'monthly_report_form'])->name('monthly_report_form');
        Route::get('/monthly/generate', [MonthlyReportsController::class, 'generate_monthly_report'])->name('generate_monthly_report');

        Route::get('/yearly', [MonthlyReportsController::class, 'yearly_report_form'])->name('yearly_report_form');
        Route::get('/yearly/generate', [MonthlyReportsController::class, 'generate_yearly_report'])->name('generate_yearly_report');

        Route::get('/full-reports', [MonthlyReportsController::class, 'full_reports'])->name('full_reports');
        Route::get('/print-reports', [MonthlyReportsController::class, 'print_reports'])->name('print_reports');
        Route::get('/print-reports/pdf', [MonthlyReportsController::class, 'download_pdf'])->name('print_reports_pdf');
    });

    Route::prefix('milk-dairy')->name('milk_dairy.')->group(function () {
        Route::get('/summary', [MilkDairyController::class, 'summary'])->name('summary');
        Route::get('/create', [MilkDairyController::class, 'create'])->name('create');
        Route::post('/store', [MilkDairyController::class, 'store'])->name('store');
        Route::post('/prev-total', [MilkDairyController::class, 'prevTotal'])
            ->name('prev_total');
        Route::get('/edit/{milkDairy}', [MilkDairyController::class, 'edit'])->name('edit');
        Route::put('/update/{milkDairy}', [MilkDairyController::class, 'update'])->name('update');
        Route::delete('/delete/{milkDairy}', [MilkDairyController::class, 'destroy'])->name('destroy');

        Route::get('/ten-days-reports', [MilkDairyController::class, 'ten_days_reports'])->name('ten_days_reports');
    });
});
