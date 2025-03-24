<?php

use App\Http\Controllers\Admin\ArticleManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\FeedbackManagementController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NewsManagementController;
use App\Http\Controllers\Admin\NewsTypeManagementController;
use App\Http\Controllers\Admin\PaymentManagementController;
use App\Http\Controllers\Admin\RevenueChartController;
use App\Http\Controllers\Admin\SliderManagementController;
use App\Http\Controllers\Admin\UserAndAdminManagementController;
use App\Http\Middleware\LoginAdmin;
use Illuminate\Support\Facades\Route;

Route::get('admin', [HomeController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('admin/login', [HomeController::class, 'store'])->name('admin.login');

// Trang quản lý
Route::prefix('admin')->name('admin.')
    ->controller(HomeController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('dashboard', 'index')->name('index');
        Route::post('register/store', 'registerStore')->name('register_store');
        Route::post('logout', 'logout')->name('logout');
    });

// Biểu đồ doanh thu
Route::prefix('admin')->name('admin.')
    ->controller(RevenueChartController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('/chart/revenue-by-day', 'revenueByDay');
        Route::get('/chart/revenue-by-payment-method', 'revenueByPaymentMethod');
        Route::get('/chart/revenue-by-month', 'revenueByMonth');
    });

// Quản lý bài viết
Route::prefix('admin')->name('admin.')
    ->controller(ArticleManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('post-unpaid', 'postUnpaid')->name('post-unpaid');
        Route::get('post-pending', 'postPending')->name('post-pending');
        Route::post('browse/{id?}', 'browse')->name('browse');
        Route::post('cancel/{id?}', 'cancel')->name('cancel');
        Route::get('post-approved', 'postApproved')->name('post-approved');
    });

// Quản lý slider
Route::prefix('admin')->name('admin.')
    ->controller(SliderManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('slider', 'slider')->name('slider');
        Route::post('slider/store', 'sliderStore')->name('slider.store');
        Route::post('slider/update/{id?}', 'sliderUpdate')->name('slider.update');
        Route::delete('slider/delete/{id?}', 'sliderDelete')->name('slider.delete');
    });

// Quản lý Category
Route::prefix('admin')->name('admin.')
    ->controller(CategoryManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('category', 'category')->name('category');
        Route::post('category/store', 'categoryStore')->name('category.store');
        Route::post('category/update/{id?}', 'categoryUpdate')->name('category.update');
        Route::post('category/delete/{id?}', 'categoryDelete')->name('category.delete');
    });

// Quản lý News Type
Route::prefix('admin')->name('admin.')
    ->controller(NewsTypeManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('new-type', 'newType')->name('new-type');
        Route::post('new-type/store', 'newTypeStore')->name('new-type.store');
        Route::post('new-type/update/{id?}', 'newTypeUpdate')->name('new-type.update');
        Route::post('new-type/delete/{id?}', 'newTypeDelete')->name('new-type.delete');
    });

// Quản lý người dùng va admin
Route::prefix('admin')->name('admin.')
    ->controller(UserAndAdminManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('user-manager', 'userManager')->name('user-manager');
        Route::post('user-manager/unlock/{id?}', 'userManagerUnlock')->name('user-manager.unlock');
        Route::post('user-manager/lock/{id?}', 'userManagerLock')->name('user-manager.lock');
        Route::post('user-manager/delete/{id?}', 'userManagerDelete')->name('user-manager.delete');
        Route::get('admin-manager', 'adminManager')->name('admin-manager');
    });

// Quan ly tin tuc
Route::prefix('admin')->name('admin.')
    ->controller(NewsManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('make-news', 'news')->name('make-news');
        Route::post('make-news/store', 'store')->name('make-news.store');
        Route::get('posted-news', 'detail')->name('posted-news');
        Route::get('edit-make-news/{id?}', 'show')->name('show');
        Route::post('edit-make-news/{id?}', 'edit')->name('edit');
        Route::delete('delete', 'destroy')->name('delete');
    });

// Quan ly thanh toan
Route::prefix('admin')->name('admin.')
    ->controller(PaymentManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('payment-history-manager', 'paymentHistoryManager')->name('payment-history-manager');
    });

// Quan ly phan hoi
Route::prefix('admin')->name('admin.')
    ->controller(FeedbackManagementController::class)
    ->middleware(LoginAdmin::class)
    ->group(function () {
        Route::get('contact-manager-new', 'unresolvedFeedback')->name('unresolved_feedback');
        Route::post('/update-status/{id?}', 'updateStatus')->name('update-status');
        Route::get('contact-manager', 'responseResolved')->name('response_resolved');
    });