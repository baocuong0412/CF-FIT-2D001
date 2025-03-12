<?php

use App\Http\Controllers\Client\AccountManagementController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\GoogleController;
use Illuminate\Support\Facades\Route;

// Google OAuth
Route::get('google/auth/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('google/auth/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Client Web
Route::prefix('client')->name('client.')
->controller(AccountManagementController::class)
->middleware('auth')
->group(function(){
    Route::get('create-post', 'create')->name('create-post'); // Đăng tin
    Route::get('personal-page', 'personalPage')->name('personal-page'); // Trang cá nhân
    Route::get('post-unpaid', 'postUnpaid')->name('post-unpaid'); // Bài viết chưa thanh toán
    Route::get('pay-by-balance/{id?}', 'payByBalance')->name('pay-by-balance'); // Thanh toán bằng số dư
    Route::post('pay-by-balance/confirm/{id?}', 'payByBalanceConfirm')->name('pay-by-balance.confirm'); // Lưu thanh toán bằng số dư
    Route::get('post-manage', 'postManage')->name('post-manage'); // Quản lý bài viết
    Route::get('deposit-money', 'depositMoney')->name('deposit-money'); // Nạp tiền
    Route::get('deposit-money-history', 'depositMoneyHistory')->name('deposit-money-history'); // Lịch sử nạp tiền
    Route::get('payment-history', 'paymentHistory')->name('payment-history'); // Lịch sử thanh toán
});

Route::prefix('client')->name('client.')
->controller(ClientController::class)
->middleware('auth')
->group(function(){
    Route::post('create-post/store', 'createPostStore')->name('create.store'); // Lưu vào DB
    Route::get('create-post/edit/{id?}', 'edit')->name('create.edit'); // Sửa bài viết
    Route::post('create-post/update/{id?}', 'createPostUpdate')->name('create.update'); // Cập nhật bài viết
    Route::delete('/delete-post/{id?}', [ClientController::class, 'deletePost'])->name('delete'); // Xóa bài viết
});
