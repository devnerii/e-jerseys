<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

// Apply middleware to authenticated routes if necessary
Route::middleware('auth')->group(function () {
    Route::get('/{slug}/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/{slug}/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/{slug?}/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/{slug}/address', [ProfileController::class, 'address'])->name('profile.address');
    Route::get('/{slug}/orders', [ProfileController::class, 'orders'])->name('profile.orders');

    Route::post('/address/save', [ProfileController::class, 'addressSave'])->name('profile.address.add');
    Route::get('/address/remove/{id}', [ProfileController::class, 'addressRemove'])->name('profile.address.remove');

    Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// The 'detect.bot' middleware is applied globally to the 'web' group in Kernel.php
Route::get('/', [HomeController::class, 'index'])->name('site.home');
Route::get('/home/{slug}', [HomeController::class, 'index'])->name('custom.home');

Route::get('/product/{productSlug?}/{slug?}', [ProductController::class, 'index'])->name('site.product');

Route::get('/products/{slug}', [ProductController::class, 'all'])->name('site.products');
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [ProductController::class, 'checkout']);

Route::get('/checkout/success', [ProductController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [ProductController::class, 'cancel'])->name('checkout.cancel');
Route::post('/checkout/webhook', [ProductController::class, 'webhook'])->name('checkout.webhook');

Route::post('/cart/add', [ProductController::class, 'cartAdd'])->name('site.cart.add');
Route::get('/cart/plus/{id}/{hash}', [ProductController::class, 'cartUpdatePlus'])->name('site.cart.plus');
Route::get('/cart/minus/{id}/{hash}', [ProductController::class, 'cartUpdateMinus'])->name('site.cart.minus');
Route::get('/cart/remove/{id}/{hash}', [ProductController::class, 'cartRemove'])->name('site.cart.remove');

Route::get('/category/{slug}', function (Request $request) {
    return redirect()->route('site.products', ['category' => $request->slug]);
})->name('site.category');

Route::get('/page/{slug}', function () {
    return view('index');
})->name('site.page');

Route::get('/home', function () {
    $redirect = session()->get('redirect', '');
    if ($redirect !== '') {
        session()->put('redirect', '');
        return redirect()->route($redirect);
    }
    return redirect()->route('site.home');
});

require __DIR__ . '/auth.php';