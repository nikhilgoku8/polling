<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PollingController;
use App\Http\Controllers\Admin\PollingCandidateController;
use App\Http\Controllers\Admin\PollingVoteController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('wm')->group(function (){

    Route::get('/register', [AdminController::class, 'register']);
    Route::get('/login', [LoginController::class, 'login']);
    Route::post('/authenticate', [LoginController::class, 'authenticate'] );
    Route::get('/logout', [LoginController::class, 'logout'] );

    Route::middleware([IsAdmin::class])->group( function (){

        Route::get('/dashboard', [LoginController::class, 'dashboard'] )->name('dashboard');

        Route::get('change_password', [LoginController::class, 'change_password'] );
        Route::post('changePasswordFunction', [LoginController::class, 'changePasswordFunction'] );

        Route::resource('users', AdminUserController::class);
        Route::post('users/bulk-delete', [AdminUserController::class, 'bulkDelete'])->name('users.bulk-delete');

        Route::resource('pollings', PollingController::class);
        Route::post('pollings/bulk-delete', [PollingController::class, 'bulkDelete'])->name('pollings.bulk-delete');

    });
});