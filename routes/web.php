<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard berdasarkan role
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'staff') {
        return redirect()->route('staff.dashboard');
    }

    if ($role === 'customer') {
        return redirect()->route('customer.dashboard');
    }

    if ($role === 'admin') {
        return app(DashboardController::class)->index();
    }

    abort(403, 'Akses ditolak.');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);

    Route::resource('suppliers', SupplierController::class)
        ->only(['index', 'create', 'store']);

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');
});

/*
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::resource('products', ProductController::class);

    Route::resource('purchases', PurchaseController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('sales', SaleController::class)
        ->only(['index', 'create', 'store']);

    Route::get('/stock-movements', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::get('/staff/dashboard', [RoleDashboardController::class, 'staff'])
        ->name('staff.dashboard');
});

/*
|--------------------------------------------------------------------------
| Customer Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer', [RoleDashboardController::class, 'customer'])
        ->name('customer.dashboard');

    Route::get('/cart', [CartController::class, 'index'])
        ->name('customer.cart');

    Route::post('/cart/add/{product}', [CartController::class, 'add'])
        ->name('customer.cart.add');

    Route::post('/checkout-direct/{product}', [CartController::class, 'checkoutDirect'])
        ->name('customer.checkout.direct');

    Route::patch('/cart/update/{product}', [CartController::class, 'update'])
        ->name('customer.cart.update');

    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])
        ->name('customer.cart.remove');

    Route::post('/cart/checkout', [CartController::class, 'checkout'])
        ->name('customer.cart.checkout');
});
