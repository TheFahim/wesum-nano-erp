<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PublicationAreaController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleTargetController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUserIsActive;
use App\Http\Middleware\CheckUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.index');
})
    ->name('dashboard.index')
    ->middleware('auth');

Route::middleware(['auth',CheckUserIsActive::class])
    ->prefix('dashboard')
    ->group(function () {
        Route::view('/', 'dashboard.index')->name('dashboard.index');


        Route::get('users/{user}/disable', [UserController::class, 'disable'])->name('users.disable')->middleware(CheckUserIsAdmin::class);
        Route::resource('users', UserController::class)->middleware(CheckUserIsAdmin::class);

        Route::resource('expense', ExpenseController::class);
        Route::resource('targets', SaleTargetController::class);


        Route::get('/customers/search', [QuotationController::class, 'searchCustomer'])->name('customers.search');



        Route::resource('quotations', QuotationController::class);

        // Route::resource('permissions', PermissionController::class);
        // Route::resource('roles', RoleController::class);
        Route::delete('logout', [SessionController::class, 'logout'])->name('logout');
    });

Route::get('login', [SessionController::class, 'login'])->name('login');
Route::post('signin', [SessionController::class, 'signIn'])->name('signIn');
// Route::get('register', [SessionController::class, 'register'])->name('register');
// Route::post('register', [SessionController::class, 'store'])->name('register.store');
