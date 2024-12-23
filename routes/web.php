<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Product;
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

Route::get('/', [FrontendController::class, 'home'])->name('home');



// Frontend
// Auth
Route::get('login', [FrontendController::class, 'login_page'])->middleware('guest')->name('login');
Route::get('register', [FrontendController::class, 'register_page'])->middleware('guest')->name('register');

Route::post('login', [FrontendController::class, 'login'])->middleware('guest')->name('login-submit');
Route::post('register', [FrontendController::class, 'register'])->middleware('guest')->name('register-submit');

Route::post('logout', [FrontendController::class, 'logout'])->middleware('auth')->name('logout');

// Products
Route::get('product-grids', [FrontendController::class, 'productGrids'])->name('product-grids');
Route::get('product-lists', [FrontendController::class, 'productLists'])->name('product-lists');
Route::post('product-grids', [FrontendController::class, 'productSearch'])->name('product-search');
Route::get('product-brand/{slug}', [FrontendController::class, 'productBrand'])->name('product-brand');
Route::get('product-cat/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
Route::get('product-detail/{slug}', [FrontendController::class, 'productDetail'])->name('product-detail');
Route::match(['get', 'post'], 'filter', [FrontendController::class, 'productFilter'])->name('product-filter');

Route::middleware(['auth'])->group(function () {
    // Carts
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::get('add-to-cart/{slug}', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::get('cart-delete/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');
    Route::post('add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-to-cart');
    Route::post('cart-update', [CartController::class, 'cartUpdate'])->name('cart-update');

    // Checkout
    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [OrderController::class, 'checkoutOrder'])->name('checkout-order');
    Route::post('checkout-cod/{order_number}', [CartController::class, 'checkoutCod'])->name('checkout-cod');
    Route::get('payment/{order_number}', [CartController::class, 'checkoutPay'])->name('chekout-payment');

    Route::get('payment-success/{order_number}', [CartController::class, 'paymentSuccess'])->name('payment-success');

    //Order Frontend
    Route::get('track-order', [OrderController::class, 'trackOrder'])->name('track-order');
    Route::get('track-order/{order_number}', [OrderController::class, 'trackOrderDetail'])->name('track-order-detail');

    //Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('profile/password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::patch('profile', [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::patch('profile/password', [ProfileController::class, 'changePasswordUser'])->name('update-password');
});

// End Frontend



// Admin & Seller
Route::middleware(['auth', 'multirole:admin,seller'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('product-backend');
    Route::post('products', [ProductController::class, 'store'])->name('add-product');
    Route::get('products/edit/{slug}', [ProductController::class, 'edit'])->name('edit-product');
    Route::patch('products/edit/{slug}', [ProductController::class, 'update'])->name('update-product');
    Route::delete('product/{slug}', [ProductController::class, 'destroy'])->name('delete-product');

    // Orders
    Route::get('orders', [OrderController::class, 'orderLists'])->name('order-lists');
    Route::get('order-detail/{order_number}', [OrderController::class, 'orderDetail'])->name('order-detail');
    Route::post('order-detail/{order_number}', [OrderController::class, 'singleProcess'])->name('single-process');
    Route::post('order-process-all', [OrderController::class, 'processAll'])->name('process-all');
});

Route::middleware(['auth', 'multirole:admin'])->group(function () {
    // Brands
    Route::get('brands', [BrandController::class, 'index'])->name('brands');
    Route::post('brands', [BrandController::class, 'store'])->name('add-brands');
    Route::get('brands/edit/{slug}', [BrandController::class, 'edit'])->name('edit-brands');
    Route::patch('brands/edit/{slug}', [BrandController::class, 'update'])->name('update-brands');
    Route::delete('brands/{slug}', [BrandController::class, 'destroy'])->name('delete-brands');

    // Categories
    Route::get('categories', [CategoriesController::class, 'index'])->name('categories');
    Route::post('categories', [CategoriesController::class, 'store'])->name('add-categories');
    Route::get('categories/edit/{slug}', [CategoriesController::class, 'edit'])->name('edit-categories');
    Route::patch('categories/edit/{slug}', [CategoriesController::class, 'update'])->name('update-categories');
    Route::delete('categories/{slug}', [CategoriesController::class, 'destroy'])->name('delete-categories');

    // Products
    Route::get('admin-products', [ProductController::class, 'allProduct'])->name('all-products');
    Route::post('admin-products', [ProductController::class, 'addProductAdmin'])->name('add-product-admin');
    Route::get('admin-products/edit/{slug}', [ProductController::class, 'editProductAdmin'])->name('edit-product-admin');
    Route::patch('admin-products/edit/{slug}', [ProductController::class, 'updateProductAdmin'])->name('update-product-admin');
    Route::delete('admin-products/{slug}', [ProductController::class, 'deleteProductAdmin'])->name('delete-product-admin');

    //User Management
    Route::get('users', [UserController::class, 'allUsers'])->name('all-users');
    Route::post('users', [FrontendController::class, 'register'])->name('add-user');
    Route::get('users/edit/{user_id}', [UserController::class, 'editUser'])->name('edit-user');
    Route::patch('users/edit/{user_id}', [UserController::class, 'updateUser'])->name('update-user');
});
