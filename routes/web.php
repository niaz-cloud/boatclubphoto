<?php

use Illuminate\Support\Facades\Route;

// Backend admin controllers
use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\AdminAuthController;
use App\Http\Controllers\backend\admin\ProfileController;

// Admin feature controllers
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\AuditorController;
use App\Http\Controllers\Admin\DuplicateRollController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\OmrErrorController;
use App\Http\Controllers\Admin\CorrectAnswerController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Global login alias (so redirect()->route('login') works)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ✅ Home route
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('admin.login');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ✅ Admin Authentication
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // ✅ Protected Admin Area
    Route::middleware(['admin.auth'])->group(function () {

        // Redirect /admin → dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Profile
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
        Route::post('/profile/password', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');

        /*
        |--------------------------------------------------------------------------
        | Core Resources
        |--------------------------------------------------------------------------
        */
        Route::resource('students', StudentController::class)->except(['show']);
        Route::resource('classes', ClassController::class)->except(['show']);
        Route::resource('auditors', AuditorController::class)->except(['show']);
        Route::resource('exams', ExamController::class)->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Results
        |--------------------------------------------------------------------------
        */
        Route::resource('results', ResultController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Duplicate Rolls
        |--------------------------------------------------------------------------
        */
        Route::resource('duplicate-rolls', DuplicateRollController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | OMR Errors
        |--------------------------------------------------------------------------
        */
        Route::get('/omr-errors', [OmrErrorController::class, 'index'])->name('omr_errors.index');
        Route::delete('/omr-errors/{omrError}', [OmrErrorController::class, 'destroy'])->name('omr_errors.destroy');

        /*
        |--------------------------------------------------------------------------
        | Correct Answers
        |--------------------------------------------------------------------------
        */
        Route::get('/correct-answers', [CorrectAnswerController::class, 'index'])->name('correct_answers.index');
        Route::get('/correct-answers/create', [CorrectAnswerController::class, 'create'])->name('correct_answers.create');
        Route::post('/correct-answers', [CorrectAnswerController::class, 'store'])->name('correct_answers.store');
        Route::delete('/correct-answers/{correctAnswer}', [CorrectAnswerController::class, 'destroy'])->name('correct_answers.destroy');

        /*
        |--------------------------------------------------------------------------
        | Attendance (✅ NEW – REAL CRUD)
        |--------------------------------------------------------------------------
        */
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

        /*
        |--------------------------------------------------------------------------
        | Exports
        |--------------------------------------------------------------------------
        */
        Route::get('/auditors-export', [AuditorController::class, 'export'])->name('auditors.export');

        /*
        |--------------------------------------------------------------------------
        | Placeholder Views (Static)
        |--------------------------------------------------------------------------
        */
        Route::view('/sections/add', 'backend.admin.sections.create')->name('sections.add');
        Route::view('/sections/list', 'backend.admin.sections.index')->name('sections.list');

        Route::view('/departments/add', 'backend.admin.departments.create')->name('departments.add');
        Route::view('/departments/list', 'backend.admin.departments.index')->name('departments.list');

        Route::view('/settings', 'backend.admin.settings.index')->name('settings');
    });
});
