<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/{username}', [FrontendController::class, 'index'])->name('index');
Route::get('/{username}/cart', [FrontendController::class, 'cart'])->name('cart');

Route::post('/{username}/checkout', [FrontendController::class, 'checkout'])->name('payment');

Route::get('/transaction/success', [FrontendController::class, 'success'])->name('success');
