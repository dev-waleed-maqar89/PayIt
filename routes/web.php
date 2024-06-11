<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('product.addToCart')->middleware('auth');
Route::post('order/checkout/{id}', [PaymentController::class, 'checkout'])->name('order.checkout')->middleware('auth');
Route::get('/checkout/success', [PaymentController::class, 'success'])->name('checkout.success')->middleware('auth');
Route::get('/checkout/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel')->middleware('auth');
Route::post('/checkout/webhook', [PaymentController::class, 'webhook'])->name('checkout.webhook');
Route::get('/order', [OrderController::class, 'index'])->name('order.index')->middleware('auth');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show')->middleware('auth');
Route::get('/register', [UserController::class, 'register'])->name('user.create')->middleware('guest');
Route::post('/register', [UserController::class, 'store'])->name('user.store')->middleware('guest');
Route::get('/login', [UserController::class, 'login'])->name('user.login')->middleware('guest');
Route::post('/login', [UserController::class, 'attempt'])->name('user.attempt')->middleware('guest');
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout')->middleware('auth');