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
use App\Http\Controllers\Admin\AttendanceReportController;
use App\Http\Controllers\Admin\AdminManagementController;

/*
|--------------------------------------------------------------------------
| Public & Global Routes
|--------------------------------------------------------------------------
*/

// Global login alias
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ✅ GLOBAL LOGOUT
Route::post('/logout', [AdminAuthController::class, 'logout'])
    ->name('logout');

// Root Home route (SMART ROLE REDIRECT)
Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('admin.login');
    }

    return match (auth()->user()->role) {
        'super_admin', 'admin' => redirect()->route('admin.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => abort(403)
    };
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ============================
    // Admin Authentication
    // ============================
    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:admin-login')   // 🔐 RATE LIMITER ADDED
        ->name('login.submit');

    // ============================
    // Protected Admin Area
    // ============================
    Route::middleware(['admin.auth'])->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])
            ->name('dashboard');

        // ============================
        // Profile Management
        // ============================
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::post('/profile/update', 'profile_info_update')->name('profile.info.update');
            Route::post('/profile/password', 'profile_password_update')->name('profile.password.update');
        });

        // ============================
        // 🔐 SUPER ADMIN → ADMIN MANAGEMENT
        // ============================
        Route::middleware(['role:super_admin'])->group(function () {

            Route::get('/admins', [AdminManagementController::class, 'index'])
                ->name('admins.index');

            Route::get('/admins/create', [AdminManagementController::class, 'create'])
                ->name('admins.create');

            Route::post('/admins', [AdminManagementController::class, 'store'])
                ->name('admins.store');
        });

        // ============================
        // Core Resources
        // ============================
        Route::resource('students', StudentController::class);
        Route::resource('classes', ClassController::class)->except(['show']);
        Route::resource('auditors', AuditorController::class)->except(['show']);
        Route::resource('exams', ExamController::class)->except(['show']);

        // ============================
        // Specialized Resources
        // ============================
        Route::resource('results', ResultController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        Route::resource('duplicate-rolls', DuplicateRollController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        // ============================
        // OMR Errors
        // ============================
        Route::get('/omr-errors', [OmrErrorController::class, 'index'])
            ->name('omr_errors.index');

        Route::delete('/omr-errors/{omrError}', [OmrErrorController::class, 'destroy'])
            ->name('omr_errors.destroy');

        // ============================
        // Correct Answers
        // ============================
        Route::resource('correct-answers', CorrectAnswerController::class)
            ->only(['index', 'create', 'store', 'destroy'])
            ->names('correct_answers');

        // ============================
        // Attendance Management
        // ============================
        Route::resource('attendance', AttendanceController::class);

        // ============================
        // Attendance Reports
        // ============================
        Route::controller(AttendanceReportController::class)->group(function () {
            Route::get('attendance-report', 'index')->name('attendance.report');
            Route::get('attendance-report/csv', 'exportCsv')->name('attendance.report.csv');
            Route::get('attendance-report/pdf', 'exportPdf')->name('attendance.report.pdf');
        });

        // ============================
        // Exports
        // ============================
        Route::get('/auditors-export', [AuditorController::class, 'export'])
            ->name('auditors.export');

        // ============================
        // Static Views
        // ============================
        Route::view('/sections/add', 'backend.admin.sections.create')->name('sections.add');
        Route::view('/sections/list', 'backend.admin.sections.index')->name('sections.list');
        Route::view('/departments/add', 'backend.admin.departments.create')->name('departments.add');
        Route::view('/departments/list', 'backend.admin.departments.index')->name('departments.list');
        Route::view('/settings', 'backend.admin.settings.index')->name('settings');

    });
});


/*
|--------------------------------------------------------------------------
| 🎓 Student Routes
|--------------------------------------------------------------------------
*/
Route::prefix('student')
    ->name('student.')
    ->middleware(['auth', 'role:student'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('backend.student.Student_dashboard');
        })->name('dashboard');

        Route::get('/results', [ResultController::class, 'studentResults'])
            ->name('results');

        Route::get('/attendance', [AttendanceController::class, 'studentAttendance'])
            ->name('attendance');

        Route::get('/profile', [ProfileController::class, 'studentProfile'])
            ->name('profile');

        Route::post('/profile/update', [ProfileController::class, 'studentProfileUpdate'])
            ->name('profile.update');

        Route::post('/password-update',
            [StudentController::class, 'updatePassword']
        )->name('password.update');

    });
