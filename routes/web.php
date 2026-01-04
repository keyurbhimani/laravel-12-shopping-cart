<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductList;
use App\Livewire\Cart;
use App\Livewire\Dashboard;

Route::view('/', 'welcome');
Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/products', ProductList::class)->name('products.index');
    Route::get('/cart', Cart::class)->name('cart');
});

require __DIR__.'/auth.php';
