<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PublicationAreaController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.index');
})
    ->name('dashboard.index')
    ->middleware('auth');

Route::middleware('auth')
    ->prefix('dashboard')
    ->group(function () {
        Route::view('/', 'dashboard.index')->name('dashboard.index');
        Route::get('users/{user}/roles', [UserController::class, 'roles'])->name('users.roles');
        Route::patch('users/{user}/role-assign', [UserController::class, 'assignRole'])->name('users.assign');
        Route::resource('users', UserController::class);

        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);

        Route::resource('publication-areas', PublicationAreaController::class);
        Route::resource('publications', PublicationController::class);

        Route::resource('galleries', GalleryController::class);
        Route::resource('teams', TeamMemberController::class);

        Route::resource('contacts', ContactController::class);
        Route::resource('news', NewsController::class);
        Route::resource('blogs', BlogController::class);

        Route::resource('technologies', TechnologyController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('resource', ResourceController::class);

        Route::delete('logout', [SessionController::class, 'logout'])->name('logout');
    });

Route::get('login', [SessionController::class, 'login'])->name('login');
Route::post('signin', [SessionController::class, 'signIn'])->name('signIn');
Route::get('register', [SessionController::class, 'register'])->name('register');
Route::post('register', [SessionController::class, 'store'])->name('register.store');
