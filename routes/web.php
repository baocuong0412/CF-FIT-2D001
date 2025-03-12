<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Types\Relations\Role;

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/category/{slug}', [HomePageController::class, 'category'])->name('category'); 
Route::get('price-list',[HomePageController::class, 'priceList'])->name('price-list'); // Bảng giá dịch vụ
Route::get('contact', [HomePageController::class, 'contact'])->name('contact'); // Liên hệ


// Route::prefix('room')->name('rooms.')->controller(HomePageController::class)->group(function(){
//     Route::get('motel-room/{slug?}', 'motelRoom')->name('motelRoom');
//     Route::get('housing/{slug?}', 'housing')->name('housing');
//     Route::get('apartment/{slug?}', 'apartment')->name('apartment');
//     Route::get('homestay/{slug?}', 'homestay')->name('homestay');
//     Route::get('shared_accommodation/{slug?}', 'sharedAccommodation')->name('shared_accommodation');
//     Route::get('premises/{slug?}', 'premises')->name('premises');
//     Route::get('new', 'new')->name('new');
// });

require __DIR__.'/auth.php';
require __DIR__.'/client_web.php';