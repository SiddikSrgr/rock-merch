<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ConfirmationController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\AdminAccountController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home'); 
Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{id}', [CategoriesController::class, 'detail']);
Route::get('/detail/{id}', [DetailController::class, 'index']);

Route::middleware(['auth', 'user'])->group(function () { 
    Route::post('/detail/{id}', [DetailController::class, 'store']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy']);
    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::get('/confirm/{id}', [ConfirmController::class, 'index'])->name('confirm');
    Route::post('/confirm/{id}', [ConfirmController::class, 'store']);
    Route::get('/transactions', [TransactionsController::class, 'index']);
    Route::get('/transaction/details/{id}', [TransactionsController::class, 'details'])->name('transaction-details');
    Route::get('/transaction-expired/{id}', [TransactionsController::class, 'expired']);
    Route::get('/review/{transactionId}/{productId}', [ReviewController::class, 'index'])->name('review');
    Route::post('/review/{id}', [ReviewController::class, 'store']);
    Route::put('/review/{transactionId}/{reviewId}', [ReviewController::class, 'update']);
    Route::resource('/account', AccountController::class);
    Route::post('/account/photo/{id}', [AccountController::class, 'updatePhoto']);
});
 
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('gallery', ProductGalleryController::class);
    Route::resource('size', SizeController::class);
    Route::resource('stock', StockController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('confirmations', ConfirmationController::class);
    Route::resource('shippings', ShippingController::class);
    Route::resource('account', AdminAccountController::class);
    Route::get('/shippings/create/{id}', [ShippingController::class, 'create']);
});