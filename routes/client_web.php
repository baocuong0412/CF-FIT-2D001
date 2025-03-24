<?php

use App\Http\Controllers\Client\DepositAndPaymentController;
use App\Http\Controllers\Client\DepositandPaymentHistoryController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\PaidRoomController;
use App\Http\Controllers\Client\RoomPostController;
use App\Http\Controllers\Client\UnpaidRoomController;
use App\Http\Controllers\Client\UserInformationController;
use Illuminate\Support\Facades\Route;

// Google OAuth
Route::get('google/auth/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('google/auth/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Quản lý thong tin cá nhân
Route::prefix('client')->name('client.')
    ->controller(UserInformationController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('personal-page', 'personalPage')->name('personal-page'); // Trang cá nhân
        Route::post('personal-page', 'updatePersonalPage')->name('update-personal-page'); // Cập nhật thông tin cá nhân
    });

// Quản lý tin đăng
Route::prefix('client')->name('client.')
    ->controller(RoomPostController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('create-post', 'create')->name('create-post'); // Đăng tin
        Route::post('create-post/store', 'createPostStore')->name('create.store'); // Lưu vào DB
    });

// Quản lý bài viết chưa thanh toán
Route::prefix('client')->name('client.')
    ->controller(UnpaidRoomController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('post-unpaid', 'postUnpaid')->name('post-unpaid'); // Bài viết chưa thanh toán
        Route::get('create-post/edit/{id?}', 'edit')->name('create.edit'); // Sửa bài viết
        Route::post('create-post/update/{id?}', 'createPostUpdate')->name('create.update'); // Cập nhật bài viết
        Route::delete('/delete-post/{id?}', 'deletePost')->name('delete'); // Xóa bài viết hoàn tiền
        Route::get('post-payment/{id?}', 'Payment')->name('payment'); // Thanh toán bài viết
    });

// Quản lý bài viết đã thanh toán
Route::prefix('client')->name('client.')
    ->controller(PaidRoomController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('post-manage', 'postManage')->name('post-manage'); // Quản lý bài viết
        Route::post('/cancel-post/{id?}', 'cancelPost')->name('cancel'); // Hủy bài viết
        Route::post('/delete/{id?}', 'delete')->name('delete'); // Xóa bài viết không hoàn tiền
    });

// Quản lý nạp tiền và thanh toán
Route::prefix('client')->name('client.')
    ->controller(DepositAndPaymentController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('deposit-money', 'depositMoney')->name('deposit-money'); // Nạp tiền
        Route::get('deposit-money-vnpay', 'depositMoneyVnpay')->name('deposit-money-vnpay'); // Nạp tiền
        Route::post('deposit-money-vnpay', 'postDepositMoneyVnpay')->name('post.deposit-money-vnpay'); // Nạp tiền
        Route::post('post-payment/{id?}', 'postPayment')->name('post-payment'); // Thanh toán bài viết
        Route::get('vnpay-callback', 'vnpayCallback')->name('vnpay.callback'); // Callback VNPAY khi thanh toán
    });

// Lịch sử nạp tiền và thanh toán
Route::prefix('client')->name('client.')
    ->controller(DepositandPaymentHistoryController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('deposit-money-history', 'depositMoneyHistory')->name('deposit-money-history'); // Lịch sử nạp tiền
        Route::get('payment-history', 'paymentHistory')->name('payment-history'); // Lịch sử thanh toán
    });
