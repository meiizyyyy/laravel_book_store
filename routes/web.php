<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;

// Route gốc
Route::get('/', function () {
    return view('welcome');
});

// Route cho admin
Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/books', [BookController::class, 'adminIndex'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});

// Route cho người dùng công khai
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Route cho giỏ hàng và thanh toán
Route::post('/order/add-to-cart', [OrderController::class, 'addToCart'])->name('order.addToCart');
Route::delete('/order/cart/remove/{index}', [OrderController::class, 'removeFromCart'])->name('order.remove');
Route::get('/order/cart', [OrderController::class, 'cart'])->name('order.cart');
Route::get('/order/details', [OrderController::class, 'showOrderDetails'])->name('order.details');
Route::post('/order/purchase', [OrderController::class, 'purchase'])->name('order.purchase');
Route::delete('/order/details', [OrderController::class, 'deleteOrder'])->name('order.delete');


// Route cho đăng nhập admin
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');
