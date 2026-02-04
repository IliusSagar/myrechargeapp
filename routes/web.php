<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\SubPackageController;
use App\Http\Controllers\MaleRechargeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RechargeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/storage-link', function () {
//     $targetFolder = storage_path('app/public');
//     $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
//     symlink($targetFolder, $linkFolder);
// });

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Done';
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/pending-approval', function () {
    return view('auth.pending');
})->name('pending.approval');

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Balance Add Routes
    Route::get('/balance/add', [App\Http\Controllers\BalanceController::class, 'showAddForm'])->name('balance.add.form');
    Route::post('/balance/add', [App\Http\Controllers\BalanceController::class, 'addBalance'])->name('balance.add');

    // package show sub-packages route
        Route::get('/packages/{package}/sub-packages', [SubPackageController::class, 'showSubPackages'])->name('package.show');
    // payment store route
    Route::post('/payment/store', [SubPackageController::class, 'payStore'])->name('payment.store');

    // Recharge Submit Route
    Route::post('/recharge/submit', [RechargeController::class, 'submitRecharge'])->name('recharge.submit');
    Route::get('/recharge/history', [RechargeController::class, 'rechargeHistory'])->name('recharge.history');

    // MaleRecharge Submit Route
    Route::post('/male/recharge/submit', [MaleRechargeController::class, 'submitRecharge'])->name('male.recharge.submit');
    Route::get('/male/recharge/history', [MaleRechargeController::class, 'rechargeHistory'])->name('male.recharge.history');

    // packag history 
    Route::get('/package/history', [RechargeController::class, 'packageHistory'])->name('packages.history');
    

    

});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // admin.users.list route is already defined above
        Route::get('/users', [AdminUserController::class, 'userList'])->name('users.list');
        Route::post('/users/{id}/approve', [AdminUserController::class, 'approve'])->name('users.approve');

        // Pending Balance Route
        Route::get('/balance/pending', [App\Http\Controllers\BalanceController::class, 'pendingBalance'])->name('balance.pending');
        // Approved Balance Route
        Route::get('/balance/approved/{id}', [App\Http\Controllers\BalanceController::class, 'approvedBalance'])->name('balance.approved');
        // Rejected Balance Route
        Route::get('/balance/rejected/{id}', [App\Http\Controllers\BalanceController::class, 'rejectedBalance'])->name('balance.rejected');
        


        Route::get('/download/{transaction}', [App\Http\Controllers\BalanceController::class, 'downloadFile'])->name('transaction.download');
        Route::post('/balance/status/{transaction}', [App\Http\Controllers\BalanceController::class, 'changeStatus'])->name('balance.changeStatus');

        // Package Routes
        Route::get('/packages', [PackageController::class, 'index'])->name('packages.list');
        Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
        Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
        Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
        Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
        // status change route
        Route::get(
            'admin/packages/status/{id}',
            [PackageController::class, 'changeStatus']
        )->name('packages.changeStatus');

        // Sub List Package Routes
        Route::get('/sub-packages', [SubPackageController::class, 'index'])->name('subpackages.list');
        Route::get('/sub-packages/create', [SubPackageController::class, 'create'])->name('subpackages.create');
        Route::post('/sub-packages', [SubPackageController::class, 'store'])->name('subpackages.store');
        Route::get('/sub-packages/{subPackage}/edit', [SubPackageController::class, 'edit'])->name('subpackages.edit');
        Route::put('/sub-packages/{subPackage}', [SubPackageController::class, 'update'])->name('subpackages.update');
        Route::delete('/sub-packages/{subPackage}', [SubPackageController::class, 'destroy'])->name('subpackages.destroy');

        // Package Order List Route
        Route::get('/package-orders', [SubPackageController::class, 'packageOrders'])->name('package.orders');
        // status pending approved rejected route
        Route::get('/package-orders/approve/{id}', [SubPackageController::class, 'approveOrder'])->name('package_orders.approve');
        Route::get('/package-orders/reject/{id}', [SubPackageController::class, 'rejectOrder'])->name('package_orders.reject');

        // Recharge Management Routes
        Route::get('/recharges', [RechargeController::class, 'index'])->name('recharges.pending');
        Route::get('/recharges/approve/{id}', [RechargeController::class, 'approveRecharge'])->name('recharges.approved');
        Route::get('/recharges/reject/{id}', [RechargeController::class, 'rejectRecharge'])->name('recharges.rejected');

        // Male Recharge Management Routes
        Route::get('/male/recharges', [MaleRechargeController::class, 'index'])->name('male.recharges.pending');
        Route::get('/male/recharges/approve/{id}', [MaleRechargeController::class, 'approveRecharge'])->name('male.recharges.approved');
        Route::get('/male/recharges/reject/{id}', [MaleRechargeController::class, 'rejectRecharge'])->name('male.recharges.rejected');

        

        // status change route
        Route::get(
            'admin/sub-packages/status/{id}',
            [SubPackageController::class, 'changeStatusSub']
        )->name('subpackages.changeStatus');
    });
});
