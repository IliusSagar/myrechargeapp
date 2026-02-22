<?php

use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AppSetupController;
use App\Http\Controllers\Backend\BankNameController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\SubPackageController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\Frontend\IbankingOrderController;
use App\Http\Controllers\MaleRechargeController;
use App\Http\Controllers\MobileBankingController;
use App\Http\Controllers\MobileBankingOrderController;
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

Route::post('/change-password', [ProfileController::class, 'changePassword'])
    ->name('password.change')
    ->middleware('auth');

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

    // iBanking Order Routes
    Route::post('/ibanking/add', [IbankingOrderController::class, 'addiBanking'])->name('ibanking.add');
    Route::get('/ibanking/history', [IbankingOrderController::class, 'iBankingHistory'])->name('ibanking.history');

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

     // Mobile Banking Order history 
    Route::get('/mobile/banking/history', [MobileBankingController::class, 'mobileBankingHistory'])->name('mobile.banking.history');
     Route::post('/mobile/banking/store', [MobileBankingController::class, 'payStore'])->name('mobile.banking.store');

    // balance history 
    Route::get('/balance/history', [BalanceController::class, 'balanceHistory'])->name('balance.history');
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Forget Password Routes
    Route::get('admin-forgot-password', [AdminForgotPasswordController::class, 'showForm'])->name('forgot');
    Route::post('admin-send-otp', [AdminForgotPasswordController::class, 'sendOtp'])->name('send.otp');
    Route::get('admin-verify-otp', [AdminForgotPasswordController::class, 'verifyForm'])->name('verify.form');
    Route::post('admin-verify-otp', [AdminForgotPasswordController::class, 'verifyOtp'])->name('verify.otp');
    Route::get('admin-reset-password', [AdminForgotPasswordController::class, 'resetForm'])->name('reset.form');
    Route::post('admin-reset-password', [AdminForgotPasswordController::class, 'resetPassword'])->name('reset.password');






    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // admin.users.list route is already defined above
        Route::get('/users', [AdminUserController::class, 'userList'])->name('users.list');
        Route::post('/users/{id}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{id}/reject', [AdminUserController::class, 'reject'])->name('users.reject');

        Route::post('/admin/users/balance/update', [AdminUserController::class, 'updateBalance'])
    ->name('users.balance.update');

        // Pending Balance Route
        Route::get('/balance/pending', [App\Http\Controllers\BalanceController::class, 'pendingBalance'])->name('balance.pending');
        // Approved Balance Route
        Route::get('/balance/approved/{id}', [App\Http\Controllers\BalanceController::class, 'approvedBalance'])->name('balance.approved');
        // Rejected Balance Route
        Route::get('/balance/rejected/{id}', [App\Http\Controllers\BalanceController::class, 'rejectedBalance'])->name('balance.rejected');



        Route::get('/download/{transaction}', [App\Http\Controllers\BalanceController::class, 'downloadFile'])->name('transaction.download');
        Route::post('/balance/status/{transaction}', [App\Http\Controllers\BalanceController::class, 'changeStatus'])->name('balance.changeStatus');

        // Mobile Banking Routes
        Route::get('/mobile/banking', [MobileBankingController::class, 'index'])->name('mobile.banking.list');
        Route::get('/mobile/banking/create', [MobileBankingController::class, 'create'])->name('mobile.banking.create');
         Route::post('/mobile/banking/packages', [MobileBankingController::class, 'store'])->name('mobile.banking.store');
          Route::get('/mobile/banking/{package}/edit', [MobileBankingController::class, 'edit'])->name('mobile.banking.edit');
           Route::put('/mobile/banking/{package}', [MobileBankingController::class, 'update'])->name('mobile.banking.update');
         Route::delete('/mobile/banking/{package}', [MobileBankingController::class, 'destroy'])->name('mobile.banking.destroy');
          Route::get(
            'admin/mobile/banking/status/{id}',
            [MobileBankingController::class, 'changeStatus']
        )->name('mobile.banking.changeStatus');

        // Bank Name Routes
        Route::get('/bank/name', [BankNameController::class, 'index'])->name('ibanking.list');
        Route::get('/bank/name/create', [BankNameController::class, 'create'])->name('ibanking.create');
        Route::post('/bank/name/store', [BankNameController::class, 'store'])->name('ibanking.store');
        Route::delete('/bank/name/{package}', [BankNameController::class, 'destroy'])->name('iBanking.destroy');
        Route::get('/bank/name/{package}/edit', [BankNameController::class, 'edit'])->name('ibanking.edit');
         Route::put('/bank/name/{package}', [BankNameController::class, 'update'])->name('ibanking.update');
         Route::get(
            'admin/bank/name/status/{id}',
            [BankNameController::class, 'changeStatus']
        )->name('iBanking.changeStatus');

        // iBanking Rate Routes
         Route::get('/ibanking/rate', [BankNameController::class, 'rate'])
            ->name('ibanking.rate');
        Route::post('/ibanking/rate/store', [BankNameController::class, 'updateRate'])
            ->name('ibanking.update');

        // iBanking Order Routes
         Route::get('/ibanking/orders/list', [IbankingOrderController::class, 'iBankingOrder'])->name('ibanking.orders.list');
          Route::get('/ibanking-orders/approve/{id}', [IbankingOrderController::class, 'approveOrder'])->name('ibanking_orders.approve');
        Route::get('/ibanking-orders/reject/{id}', [IbankingOrderController::class, 'rejectOrder'])->name('ibanking_orders.reject');
          Route::put('/ibanking-orders/{id}/upload-slip', 
        [IbankingOrderController::class, 'uploadSlip']
    )->name('ibanking_orders.upload_slip');

        // Mobile Banking order Routes
         Route::get('/mobile/banking/orders/list', [MobileBankingOrderController::class, 'index'])->name('mobile.banking.orders.list');
         Route::get('/mobile/banking-orders/approve/{id}', [MobileBankingOrderController::class, 'approveOrder'])->name('mobile_banking_orders.approve');
        Route::get('/mobile/banking-orders/reject/{id}', [MobileBankingOrderController::class, 'rejectOrder'])->name('mobile_banking_orders.reject');
        Route::put('/admin/mobile-banking-orders/{id}/update-note',
    [MobileBankingOrderController::class, 'updateNote'])
    ->name('mobile_banking_orders.update_note');
  


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

         Route::get('/package/orders/{id}', [SubPackageController::class, 'orders'])
      ->name('admin.package.orders');


        // Recharge Management Routes
        Route::get('/recharges', [RechargeController::class, 'index'])->name('recharges.pending');
        Route::get('/recharges/approve/{id}', [RechargeController::class, 'approveRecharge'])->name('recharges.approved');
        Route::get('/recharges/reject/{id}', [RechargeController::class, 'rejectRecharge'])->name('recharges.rejected');

        // Male Recharge Management Routes
        Route::get('/male/recharges', [MaleRechargeController::class, 'index'])->name('male.recharges.pending');
        Route::get('/male/recharges/approve/{id}', [MaleRechargeController::class, 'approveRecharge'])->name('male.recharges.approved');
        Route::get('/male/recharges/reject/{id}', [MaleRechargeController::class, 'rejectRecharge'])->name('male.recharges.rejected');

        // Admin Setup Content
        Route::get('/app-setup/content', [AppSetupController::class, 'content'])
            ->name('setup.content');
        Route::post('/app-setup/content', [AppSetupController::class, 'update'])
            ->name('setup.content.update');
        Route::get('/app-setup/notification', [AppSetupController::class, 'notification'])
            ->name('notification.message');
        Route::post('/app-setup/notification/update', [AppSetupController::class, 'updateNotification'])
            ->name('setup.notification.update');

        // change password
        Route::get('/app-setup/change/password', [AppSetupController::class, 'changePassword'])
            ->name('change.password');
        Route::post('/app-setup/change/password/update', [AppSetupController::class, 'updatePassword'])
            ->name('setup.password.update');

            // Admin Setup Social
        Route::get('/app-setup/social', [AppSetupController::class, 'social'])
            ->name('setup.social');
        Route::post('/app-setup/social', [AppSetupController::class, 'updateSocial'])
            ->name('setup.social.update');

        // status change route
        Route::get(
            'admin/sub-packages/status/{id}',
            [SubPackageController::class, 'changeStatusSub']
        )->name('subpackages.changeStatus');
    });
});
