<?php

use App\Http\Controllers\Include\CommentController;
use App\Http\Controllers\Include\HomePageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/category/{slug?}', [HomePageController::class, 'category'])->name('category');
Route::get('detail/{id?}', [HomePageController::class, 'detail'])->name('detail');
Route::get('search', [HomePageController::class, 'search'])->name('search');
Route::get('news', [HomePageController::class, 'news'])->name('news');
Route::get('price-list', [HomePageController::class, 'priceList'])->name('price-list'); // Bảng giá dịch vụ
Route::get('contact', [HomePageController::class, 'contact'])->name('contact'); // Liên hệ
Route::post('post_contact',[HomePageController::class, 'postContact'])->name('post_contact');

Route::post('replies/{id?}', [CommentController::class, 'replie'])->name('replie')->middleware('auth');
Route::post('comment/{id?}', [CommentController::class, 'comment'])->name('comment')->middleware('auth');

require __DIR__ . '/auth.php';
require __DIR__ . '/client_web.php';
require __DIR__ . '/admin_web.php';
