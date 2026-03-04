<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

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
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\PaymentController;

// Teacher controllers
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherStudentController;
use App\Http\Controllers\Teacher\TeacherAttendanceController;
use App\Http\Controllers\Teacher\TeacherResultController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');

Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('admin.login');
    }

    if (auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->hasRole('Teacher')) {
        return redirect()->route('teacher.dashboard');
    }

    if (auth()->user()->hasRole('Student')) {
        return redirect()->route('student.dashboard');
    }

    abort(403);
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:admin-login')
        ->name('login.submit');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Area
    |--------------------------------------------------------------------------
    */

    Route::middleware(['admin.auth'])->group(function () {

        Route::get('/', fn() => redirect()->route('admin.dashboard'));

        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::post('/profile/update', 'profile_info_update')->name('profile.info.update');
            Route::post('/profile/password', 'profile_password_update')->name('profile.password.update');
        });

        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN ONLY
        |--------------------------------------------------------------------------
        */

        Route::middleware('role:Super Admin')->group(function () {

            Route::resource('admins', AdminManagementController::class);

            Route::post('/admins/{admin}/reset-password', [AdminManagementController::class, 'resetPassword'])
                ->name('admins.reset_password');

            Route::get('/role-permissions', [RolePermissionController::class, 'index'])
                ->name('role_permissions.index');

            Route::get('/role-permissions/{role}', [RolePermissionController::class, 'edit'])
                ->name('role_permissions.edit');

            Route::post('/role-permissions/{role}', [RolePermissionController::class, 'update'])
                ->name('role_permissions.update');
        });

        /*
        |--------------------------------------------------------------------------
        | ADMIN + SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        Route::middleware('role:Super Admin|Admin')->group(function () {

            Route::resource('students', StudentController::class);
            Route::resource('classes', ClassController::class)->except(['show']);
            Route::resource('auditors', AuditorController::class)->except(['show']);
            Route::resource('exams', ExamController::class)->except(['show']);

            Route::resource('results', ResultController::class)
                ->only(['index', 'create', 'store', 'destroy']);

            Route::resource('duplicate-rolls', DuplicateRollController::class)
                ->only(['index', 'create', 'store', 'destroy']);

            Route::resource('attendance', AttendanceController::class);

            Route::controller(AttendanceReportController::class)->group(function () {
                Route::get('attendance-report', 'index')->name('attendance.report');
                Route::get('attendance-report/csv', 'exportCsv')->name('attendance.report.csv');
                Route::get('attendance-report/pdf', 'exportPdf')->name('attendance.report.pdf');
            });

            Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

            Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');

            Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

            Route::post('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])
                ->name('payments.mark_paid');

            // Settings
            Route::get('/settings', function () {
                return view('backend.admin.settings.index');
            })->name('settings');
            Route::post('/settings', function () {
                return back()->with('success', 'Settings saved successfully');
            })->name('settings.save');
            Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class);
        });
    });
});


/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::prefix('student')
    ->name('student.')
    ->middleware(['auth', 'role:Student'])
    ->group(function () {

        Route::get('/dashboard', fn() => view('backend.student.Student_dashboard'))
            ->name('dashboard');

        Route::get('/results', [ResultController::class, 'studentResults'])
            ->name('results');

        Route::get('/attendance', [AttendanceController::class, 'studentAttendance'])
            ->name('attendance');
    });


/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::prefix('teacher')
    ->name('teacher.')
    ->middleware(['auth', 'role:Teacher'])
    ->group(function () {

        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/students', [TeacherStudentController::class, 'index'])
            ->name('students.index');

        Route::get('/students/{student}', [TeacherStudentController::class, 'show'])
            ->name('students.show');

        Route::get('/attendance/create/{student}', [TeacherAttendanceController::class, 'create'])
            ->name('attendance.create');

        Route::post('/attendance/store', [TeacherAttendanceController::class, 'store'])
            ->name('attendance.store');

        Route::get('/results/create/{student}', [TeacherResultController::class, 'create'])
            ->name('results.create');

        Route::post('/results/store', [TeacherResultController::class, 'store'])
            ->name('results.store');
    });
