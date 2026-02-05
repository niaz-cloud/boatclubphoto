<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\ClassModel;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [];

        // Page info
        $data['page_title']  = 'SMS Admin (SIS)';
        $data['active_menu'] = 'dashboard';

        // Default values
        $data['total_students']       = 0;
        $data['total_exams']          = 0;
        $data['total_results']        = 0;
        $data['total_classes']        = 0;
        $data['active_classes']       = 0;

        $data['recent_classes']       = collect();
        $data['students_per_class']   = collect(); // pie
        $data['attendance_per_class'] = collect(); // bar

        try {

            // Totals
            if (Schema::hasTable('students')) {
                $data['total_students'] = DB::table('students')->count();
            }

            if (Schema::hasTable('exams')) {
                $data['total_exams'] = DB::table('exams')->count();
            }

            if (Schema::hasTable('results')) {
                $data['total_results'] = DB::table('results')->count();
            }

            // Class info
            if (Schema::hasTable('classes')) {
                $data['total_classes']  = ClassModel::count();
                $data['active_classes'] = ClassModel::where('status', 1)->count();

                $data['recent_classes'] = ClassModel::latest()
                    ->limit(5)
                    ->get();
            }

            // =============================
            // PIE CHART: Students per class
            // =============================
            if (
                Schema::hasTable('students') &&
                Schema::hasTable('classes') &&
                Schema::hasColumn('students', 'class_id')
            ) {
                $data['students_per_class'] = DB::table('students')
                    ->join('classes', 'students.class_id', '=', 'classes.id')
                    ->select(
                        'classes.class_name',
                        DB::raw('COUNT(students.id) as total_students')
                    )
                    ->groupBy('classes.class_name')
                    ->orderBy('classes.class_name')
                    ->pluck('total_students', 'classes.class_name');
            }

            // =============================
            // BAR CHART: Attendance per class
            // =============================
            if (
                Schema::hasTable('attendance') &&
                Schema::hasTable('classes') &&
                Schema::hasColumn('attendance', 'class_id')
            ) {
                $query = DB::table('attendance')
                    ->join('classes', 'attendance.class_id', '=', 'classes.id');

                // If status column exists, count only present students
                if (Schema::hasColumn('attendance', 'status')) {
                    $query->where('attendance.status', 'present');
                }

                $data['attendance_per_class'] = $query
                    ->select(
                        'classes.class_name',
                        DB::raw('COUNT(attendance.id) as total_attendance')
                    )
                    ->groupBy('classes.class_name')
                    ->orderBy('classes.class_name')
                    ->get();
            }

        } catch (\Throwable $e) {
            // keep dashboard safe
        }

        return view('backend.admin.pages.dashboard', compact('data'));
    }
}
