<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BranchUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Staff\ExpensesController;
use App\Http\Controllers\Staff\IncomesController;
use Illuminate\Support\Facades\Route;

Route::get('/', action: function () {
    return view('auth.login');
});


Route::middleware('guest')->group(function () {
    Route::get('/login',[AuthController::class,'showLogin'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login.post');
});

Route::post('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
   Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
   Route::resource('user', UserController::class);
   Route::resource('branch', BranchController::class);
   Route::resource('branchUser', BranchUserController::class);
});

Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
   Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
   Route::resource('incomes', IncomesController::class);
   Route::resource('expenses', ExpensesController::class);
});