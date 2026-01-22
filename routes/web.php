<?php

use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\ProfileController;
use App\Http\Controllers\backend\AuthenticationController;
use App\Http\Controllers\backend\operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\backend\operator\ProfileController as OperatorProfileController;
use App\Http\Controllers\FrontEndController;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\OperatorAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

// frontend
Route::get('/', [FrontEndController::class, 'home'])->name('home');

// backend login
Route::match(['get', 'post'], 'login', [AuthenticationController::class, 'login'])->name('login');


// ==========================
// ADMIN ROUTES
// ==========================
Route::prefix('admin')->name('admin.')->middleware(AdminAuthenticationMiddleware::class)->group(function () {

    // auth
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    // profile
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('profile-info/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
    Route::post('profile-password/update', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


    // --------------------------
    // ROOM MANAGE (Dropdown)
    // --------------------------
    Route::get('room-categories/add', function () {
        return 'Room Categories Add (Create controller + view later)';
    })->name('room.categories.add');

    Route::get('room-categories/list', function () {
        return 'Room Categories List (Create controller + view later)';
    })->name('room.categories.list');


    // --------------------------
    // INVOICE MANAGE (Dropdown)
    // --------------------------
    Route::get('invoice-add', function () {
        return 'Invoice Add (Create controller + view later)';
    })->name('invoice.add');

    Route::get('checked-in-guest', function () {
        return 'Checked-in Guest (Create controller + view later)';
    })->name('invoice.checked_in_guest');

    Route::get('due-list', function () {
        return 'Due List (Create controller + view later)';
    })->name('invoice.due_list');

    Route::get('full-paid-list', function () {
        return 'Full Paid List (Create controller + view later)';
    })->name('invoice.full_paid_list');

    Route::get('booked-list', function () {
        return 'Booked List (Create controller + view later)';
    })->name('invoice.booked_list');

});


// ==========================
// OPERATOR ROUTES
// ==========================
Route::prefix('operator')->name('operator.')->middleware(OperatorAuthenticationMiddleware::class)->group(function () {

    // auth
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    // profile
    Route::get('profile', [OperatorProfileController::class, 'profile'])->name('profile');
    Route::post('profile-info/update', [OperatorProfileController::class, 'profile_info_update'])->name('profile.info.update');
    Route::post('profile-password/update', [OperatorProfileController::class, 'profile_password_update'])->name('profile.password.update');

    // dashboard
    Route::get('dashboard', [OperatorDashboardController::class, 'dashboard'])->name('dashboard');
});
