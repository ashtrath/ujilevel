<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/shop', [ShopController::class, 'shop']);
Route::get('/contact', [ContactController::class, 'contact']);
Route::get('/cart', [CartController::class, 'cart']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/testimoni', [TestimoniController::class, 'testimoni']);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === UserRole::Admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    Route::middleware('role:Admin')->group(function () {

        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::resource('/category', CategoryController::class)
                ->names('admin.category');
            Route::resource('/product', ProductController::class)
                ->names('admin.product');

            Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
            Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
            Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
            Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

            Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
            Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

            Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('admin.payment_methods.index');
            Route::get('/payment-methods/create', [PaymentMethodController::class, 'create'])->name('admin.payment_methods.create');
            Route::get('/payment-methods/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('admin.payment_methods.edit');
Route::put('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('admin.payment_methods.update');
            Route::post('/payment-methods', [PaymentMethodController::class, 'store'])->name('admin.payment_methods.store');
            Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('admin.payment_methods.destroy');
        });
    });

    Route::middleware('role:User')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
            Route::resource('category', CategoryController::class);
        });
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
