<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BranchUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Staff\BudgetRequestController;
use App\Http\Controllers\Staff\ExpensesController;
use App\Http\Controllers\Staff\IncomesController;
use App\Http\Controllers\Finance\IncomesController as FinanceIncomesController;
use App\Http\Controllers\Finance\ExpensesController as FinanceExpensesController;
use App\Http\Controllers\Finance\BudgetRequestController as FinanceBudgetRequestController;
use App\Http\Controllers\Staff\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', action: function () {
    return view('auth.login');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('branch', BranchController::class);
    Route::resource('branchUser', BranchUserController::class);
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('incomes', IncomesController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('budget_requests', BudgetRequestController::class);
    Route::resource('projects', ProjectController::class);
    Route::get('/profile', [UserController::class, 'editProfileStaff'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfileStaff'])->name('profile.update');
});

Route::prefix('finance')->name('finance.')->middleware(['auth', 'role:finance'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('incomes', FinanceIncomesController::class);
    Route::resource('expenses', FinanceExpensesController::class);
    Route::get('/budget_request', [FinanceBudgetRequestController::class, 'index'])->name('budget_requests.index');
    Route::post('/budget_requests/{id}/approve', [FinanceBudgetRequestController::class, 'approve'])
        ->name('budget_requests.approve');
    Route::post('/budget_requests/{id}/reject', [FinanceBudgetRequestController::class, 'reject'])
        ->name('budget_requests.reject');
    Route::post('/budget_requests/{id}/reject/update', [FinanceBudgetRequestController::class, 'rejectUpdate'])
        ->name('budget_requests.reject.update');
    Route::get('/profile', [UserController::class, 'editProfileFinance'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfileFinance'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');
    Route::delete('/notifications/delete/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.delete');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'destroyAll'])
        ->name('notifications.deleteAll');
    // fetch AJAX navbar
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])
        ->name('notifications.fetch');
});