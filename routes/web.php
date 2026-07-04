<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/start', [MenuController::class, 'start'])->name('start');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/api/menu/search', [MenuController::class, 'search'])->name('menu.search');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
Route::post('/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [MenuController::class, 'cart'])->name('cart.index');
Route::post('/cart/checkout', [MenuController::class, 'checkout'])->name('cart.checkout');
Route::get('/receipt', [MenuController::class, 'receipt'])->name('receipt');
Route::post('/receipt/reset', [MenuController::class, 'reset'])->name('receipt.reset');
Route::get('/start/reset', [MenuController::class, 'fullReset'])->name('start.reset');
Route::get('/api/order/{id}/status', [MenuController::class, 'orderStatus'])->name('api.order.status');

// Admin Auth Routes
use App\Http\Controllers\AuthController;
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard Routes
use App\Http\Controllers\AdminController;
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/search', [AdminController::class, 'search'])->name('search');
    Route::get('/pesanan-masuk', [AdminController::class, 'pesananMasuk'])->name('pesanan-masuk');
    Route::put('/pesanan/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('pesanan.status');
    Route::put('/pesanan/{id}/pay', [AdminController::class, 'payOrder'])->name('pesanan.pay');
    Route::put('/pesanan/{id}/items', [AdminController::class, 'updateOrderItems'])->name('pesanan.items');
    Route::delete('/pesanan/{id}', [AdminController::class, 'destroyOrder'])->name('pesanan.destroy');
    Route::get('/pesanan-diproses', [AdminController::class, 'pesananDiproses'])->name('pesanan-diproses');
    Route::get('/menu', [AdminController::class, 'menu'])->name('menu');
    Route::get('/menu/create', [AdminController::class, 'createMenu'])->name('menu.create');
    Route::post('/menu', [AdminController::class, 'storeMenu'])->name('menu.store');
    Route::get('/menu/{id}', [AdminController::class, 'showMenu'])->name('menu.show');
    Route::get('/menu/{id}/edit', [AdminController::class, 'editMenuForm'])->name('menu.edit');
    Route::put('/menu/{id}', [AdminController::class, 'updateMenu'])->name('menu.update');
    Route::delete('/menu/{id}', [AdminController::class, 'destroyMenu'])->name('menu.destroy');
    Route::get('/kategori', [AdminController::class, 'kategori'])->name('kategori');
    Route::post('/kategori', [AdminController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{id}', [AdminController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('kategori.destroy');
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('riwayat');
});
