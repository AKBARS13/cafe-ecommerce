<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminTableController;
use App\Http\Controllers\Admin\AdminCafeSettingController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [ProductController::class, 'index'])->name('products.index');
Route::get('/menu/{slug}', [ProductController::class, 'show'])->name('products.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer Routes
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cartItemId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderId}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Product Management
    Route::resource('products', AdminProductController::class);

    // Category Management
    Route::resource('categories', AdminCategoryController::class);

    // Table Management
    Route::resource('tables', AdminTableController::class);
    Route::put('/tables/{table}/status', [AdminTableController::class, 'updateStatus'])->name('tables.updateStatus');

    // Cafe Settings
    Route::get('/settings', [AdminCafeSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminCafeSettingController::class, 'update'])->name('settings.update');

    // Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderId}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{orderId}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('/orders/{orderId}/assign-table', [AdminOrderController::class, 'assignTable'])->name('orders.assignTable');
    Route::delete('/orders/{orderId}/release-table', [AdminOrderController::class, 'releaseTable'])->name('orders.releaseTable');
});