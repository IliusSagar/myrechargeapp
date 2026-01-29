<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\SubPackageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
});

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
        Route::get('/balance/approved', [App\Http\Controllers\BalanceController::class, 'approvedBalance'])->name('balance.approved');
        // Rejected Balance Route
        Route::get('/balance/rejected', [App\Http\Controllers\BalanceController::class, 'rejectedBalance'])->name('balance.rejected');
        


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

        // status change route
        Route::get(
            'admin/sub-packages/status/{id}',
            [SubPackageController::class, 'changeStatusSub']
        )->name('subpackages.changeStatus');
    });
});
