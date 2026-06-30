<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});
Route::prefix('/admin')->name('admin.')->group(function () {

    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login.page');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login');
    });

    // Protected routes
    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Categories routes
        Route::resource('/categories', CategoryController::class);
        // Products routes
        Route::resource('/products', ProductController::class);
        // Order routes
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        // Users Management
        Route::get('users',                   [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}',            [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit',       [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}',            [UserController::class, 'update'])->name('users.update');
        Route::patch('users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');
        Route::delete('users/{user}',            [UserController::class, 'destroy'])->name('users.destroy');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');


        Route::resource('collections', CollectionController::class);
    });
});
