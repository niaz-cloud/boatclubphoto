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

        // =============================
        // Basic page info
        // =============================
        $data['page_title']  = 'SMS Admin (SIS)';
        $data['active_menu'] = 'dashboard';

        // =============================
        // Defaults
        // =============================
        $data['total_students'] = 0;
        $data['total_exams']    = 0;
        $data['total_results']  = 0;

        $data['total_classes']  = 0;
        $data['active_classes'] = 0;
        $data['recent_classes'] = collect();

        // Chart data
        $data['students_per_class'] = collect();

        try {

            // =============================
            // Detect tables
            // =============================
            $studentsTable = Schema::hasTable('students') ? 'students' : null;
            $examsTable    = Schema::hasTable('exams') ? 'exams' : null;
            $resultsTable  = Schema::hasTable('results') ? 'results' : null;

            // =============================
            // Totals
            // =============================
            if ($studentsTable) $data['total_students'] = DB::table($studentsTable)->count();
            if ($examsTable)    $data['total_exams']    = DB::table($examsTable)->count();
            if ($resultsTable)  $data['total_results']  = DB::table($resultsTable)->count();

            // =============================
            // Class statistics
            // =============================
            if (Schema::hasTable('classes')) {

                $data['total_classes']  = ClassModel::count();
                $data['active_classes'] = ClassModel::where('status', 1)->count();

                $data['recent_classes'] = ClassModel::latest()
                    ->limit(5)
                    ->get();
            }

            // =============================
            // ✅ PIE CHART: Students per class (FIXED)
            // =============================
            if (
                Schema::hasTable('students') &&
                Schema::hasTable('classes') &&
                Schema::hasColumn('students', 'class_id')
            ) {
                $data['students_per_class'] = DB::table('students')
                    ->join('classes', 'students.class_id', '=', 'classes.id')
                    ->select('classes.class_name', DB::raw('COUNT(students.id) as total'))
                    ->groupBy('classes.class_name')
                    ->pluck('total', 'classes.class_name');
            }

        } catch (\Throwable $e) {
            // Dashboard must never crash
        }

        return view('backend.admin.pages.dashboard', compact('data'));
    }
}
