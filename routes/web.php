<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Client\CategoriesClientController;
use App\Http\Controllers\Client\ProductClientController;
use App\Http\Controllers\Client\CartClientController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ReviewClientController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Admin\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginClient'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'registerClient'])->name('register.post');
Route::get('/register/success', [AuthController::class, 'registerSuccess'])->name('register.success');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('categories', [CategoriesClientController::class, 'showClient'])->name('categories.showClient');
Route::get('product', [ProductClientController::class, 'showClient'])->name('products.showClient');
Route::post('products/reviews/{id}', [ReviewClientController::class, 'storeReview'])->name('products.storeReview');
Route::put('products/reviews/{id}/update', [ReviewClientController::class, 'updateReview'])->name('products.updateReview');
Route::post('products/reviews/{id}/like', [ReviewClientController::class, 'likeReview'])->name('products.likeReview');
Route::get('products/{slug}/{id}', [ProductClientController::class, 'productDetailClient'])->name('products.detailClient');
Route::prefix('cart')->group(function () {
    Route::get('/', [CartClientController::class, 'cartClient'])->name('cart.showClient');
    Route::post('/add', [CartClientController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartClientController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartClientController::class, 'remove'])->name('cart.remove');
    Route::post('/apply-coupon', [CartClientController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::post('/remove-coupon', [CartClientController::class, 'removeCoupon'])->name('cart.removeCoupon');
});

Route::post('/buy-now', [CartClientController::class, 'buyNow'])->name('cart.buyNow');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/checkout/validate', [CheckoutController::class, 'validateCheckout'])->name('checkout.validate');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/overview', [ProfileController::class, 'index'])->name('profile.overview');
    Route::post('/profile/orders/{id}/cancel', [ProfileController::class, 'cancelOrder'])->name('profile.orders.cancel');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{id}', [ProfileController::class, 'showOrder'])->name('profile.orders.show');
    Route::get('/profile/quotes', [ProfileController::class, 'quotes'])->name('profile.quotes');
    Route::get('/profile/info', [ProfileController::class, 'editInfo'])->name('profile.info');
    Route::post('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.info.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/points', [ProfileController::class, 'points'])->name('profile.points');
    Route::get('/profile/vouchers', [ProfileController::class, 'vouchers'])->name('profile.vouchers');
    Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');


    // Shipping Address routes
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::put('/profile/addresses/{id}', [ProfileController::class, 'updateAddress'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{id}', [ProfileController::class, 'deleteAddress'])->name('profile.addresses.destroy');
    Route::post('/profile/addresses/{id}/default', [ProfileController::class, 'setDefaultAddress'])->name('profile.addresses.default');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'loginAdmin']);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::prefix('categories')->middleware('role')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{id}', [CategoriesController::class, 'show'])->name('categories.show');
        Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::put('/{id}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::patch('/{id}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
        Route::get('/{id}/check', [CategoriesController::class, 'checkHasProducts'])->name('categories.check');
        Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::get('/{slug}/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::patch('/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::get('/{slug}/{id}', [BrandController::class, 'show'])->name('brands.show');
        Route::put('/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::patch('/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
        Route::delete('/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    });
    Route::prefix('coupons')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupons.index');
        Route::get('/create', [CouponController::class, 'create'])->name('coupons.create');
        Route::post('/', [CouponController::class, 'store'])->name('coupons.store');
        Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/{id}', [CouponController::class, 'update'])->name('coupons.update');
        Route::delete('/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UserAdminController::class, 'index'])->name('users.index');
        Route::get('/create', [UserAdminController::class, 'create'])->name('users.create');
        Route::post('/', [UserAdminController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserAdminController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserAdminController::class, 'update'])->name('users.update');
        Route::patch('/{id}/restore', [UserAdminController::class, 'restore'])->name('users.restore');
        Route::delete('/{id}', [UserAdminController::class, 'destroy'])->name('users.destroy');
    });
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
});
