<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Admin-only CRUD
        Route::middleware('role:admin')->group(function () {
            Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
            Route::resource('suppliers', \App\Http\Controllers\Admin\SupplierController::class);
            Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
            Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
            Route::resource('promotions', \App\Http\Controllers\Admin\PromotionController::class);

            Route::resource('positions', \App\Http\Controllers\Admin\PositionController::class);
            Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);

            Route::resource('attendances', \App\Http\Controllers\Admin\AttendanceController::class)
                ->only(['index', 'store', 'update', 'destroy']);

            // Inventory transactions
            Route::get('inventory/transactions', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])
                ->name('inventory.transactions');

            Route::post('inventory/in', [\App\Http\Controllers\Admin\InventoryController::class, 'stockIn'])
                ->name('inventory.in');

            Route::post('inventory/out', [\App\Http\Controllers\Admin\InventoryController::class, 'stockOut'])
                ->name('inventory.out');

            Route::post('inventory/broken', [\App\Http\Controllers\Admin\InventoryController::class, 'broken'])
                ->name('inventory.broken');

            Route::post('inventory/transfer', [\App\Http\Controllers\Admin\InventoryController::class, 'transfer'])
                ->name('inventory.transfer');

            // Reports
            Route::get('reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])
                ->name('reports.sales');

            Route::get('reports/stock', [\App\Http\Controllers\Admin\ReportController::class, 'stock'])
                ->name('reports.stock');

            Route::get('reports/transactions', [\App\Http\Controllers\Admin\ReportController::class, 'transactions'])
                ->name('reports.transactions');
        });

        // POS (admin + cashier)
        Route::middleware('role:admin,cashier')->group(function () {
            Route::get('pos', [\App\Http\Controllers\POS\PosController::class, 'index'])->name('pos.index');

            // ❌ Remove this route if you don't have PosController@products
            // Route::get('pos/products', [\App\Http\Controllers\POS\PosController::class, 'products'])->name('pos.products');

            Route::post('pos/checkout', [\App\Http\Controllers\POS\PosController::class, 'checkout'])->name('pos.checkout');
            Route::get('pos/sales/{sale}', [\App\Http\Controllers\POS\PosController::class, 'show'])->name('pos.sales.show');
        });

    });

});
