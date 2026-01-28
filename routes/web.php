<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\AdminAuthController;
use App\Http\Controllers\backend\admin\AdminProfileController;

use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\AuditorController;
use App\Http\Controllers\Admin\DuplicateRollController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\OmrErrorController;
use App\Http\Controllers\Admin\CorrectAnswerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Global login alias route
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ✅ Home route (send guest to login, logged-in to dashboard)
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

    // ✅ Admin Auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // ✅ Protected Admin Area
    Route::middleware(['admin.auth'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        // ✅ Resources
        Route::resource('exams', ExamController::class)->except(['show']);
        Route::resource('auditors', AuditorController::class)->except(['show']);
        Route::resource('students', StudentController::class)->except(['show']);

        // ✅ OMR Errors
        Route::get('/omr-errors', [OmrErrorController::class, 'index'])->name('omr_errors.index');
        Route::delete('/omr-errors/{omrError}', [OmrErrorController::class, 'destroy'])->name('omr_errors.destroy');

        // ✅ Correct Answers
        Route::get('/correct-answers', [CorrectAnswerController::class, 'index'])->name('correct_answers.index');
        Route::get('/correct-answers/create', [CorrectAnswerController::class, 'create'])->name('correct_answers.create');
        Route::post('/correct-answers', [CorrectAnswerController::class, 'store'])->name('correct_answers.store');
        Route::delete('/correct-answers/{correctAnswer}', [CorrectAnswerController::class, 'destroy'])->name('correct_answers.destroy');

        // ✅ Auditor Excel Export
        Route::get('/auditors-export', [AuditorController::class, 'export'])->name('auditors.export');

        // ✅ Duplicate Rolls
        Route::resource('duplicate-rolls', DuplicateRollController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        // ✅ Results
        Route::resource('results', ResultController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        // ✅ Profile (FIXED)
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // ✅ Placeholder view routes
        Route::view('/classes/add', 'backend.admin.classes.create')->name('classes.add');
        Route::view('/classes/list', 'backend.admin.classes.index')->name('classes.list');

        Route::view('/sections/add', 'backend.admin.sections.create')->name('sections.add');
        Route::view('/sections/list', 'backend.admin.sections.index')->name('sections.list');

        Route::view('/departments/add', 'backend.admin.departments.create')->name('departments.add');
        Route::view('/departments/list', 'backend.admin.departments.index')->name('departments.list');

        Route::view('/attendance', 'backend.admin.attendance.index')->name('attendance');
        Route::view('/settings', 'backend.admin.settings.index')->name('settings');
    });
});
