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
        // Defaults (blade safety)
        // =============================
        $data['total_students']        = 0;
        $data['total_auditors']        = 0;
        $data['total_exams']           = 0;
        $data['total_results']         = 0;
        $data['total_omr_errors']      = 0;
        $data['total_correct_answers'] = 0;
        $data['total_duplicate_rolls'] = 0;

        // ✅ Class stats (NEW)
        $data['total_classes']   = 0;
        $data['active_classes']  = 0;
        $data['inactive_classes'] = 0;
        $data['recent_classes']  = collect();

        $data['latest_students'] = collect();
        $data['latest_results']  = collect();

        try {

            // =============================
            // Detect tables
            // =============================
            $studentsTable = $this->firstExistingTable(['students', 'student', 'student_lists', 'student_list']);
            $auditorsTable = $this->firstExistingTable(['auditors', 'auditor', 'auditor_lists', 'auditor_list']);
            $examsTable    = $this->firstExistingTable(['exams', 'exam', 'exam_lists', 'exam_list']);
            $resultsTable  = $this->firstExistingTable(['results', 'result', 'result_lists', 'result_list']);
            $omrTable      = $this->firstExistingTable(['omr_errors', 'omr_error', 'omrerror', 'omr_errors_list']);
            $answersTable  = $this->firstExistingTable(['correct_answers', 'correct_answer', 'answers', 'answer_keys']);
            $dupTable      = $this->firstExistingTable(['duplicate_rolls', 'duplicate_roll', 'duplicate_roll_numbers', 'duplicate_roll_list']);

            // =============================
            // Total counts
            // =============================
            if ($studentsTable) $data['total_students'] = DB::table($studentsTable)->count();
            if ($auditorsTable) $data['total_auditors'] = DB::table($auditorsTable)->count();
            if ($examsTable)    $data['total_exams']    = DB::table($examsTable)->count();
            if ($resultsTable)  $data['total_results']  = DB::table($resultsTable)->count();
            if ($omrTable)      $data['total_omr_errors'] = DB::table($omrTable)->count();
            if ($answersTable)  $data['total_correct_answers'] = DB::table($answersTable)->count();
            if ($dupTable)      $data['total_duplicate_rolls'] = DB::table($dupTable)->count();

            // =============================
            // Class statistics (NEW)
            // =============================
            if (Schema::hasTable('classes')) {
                $data['total_classes']    = ClassModel::count();
                $data['active_classes']   = ClassModel::where('status', 1)->count();
                $data['inactive_classes'] = ClassModel::where('status', 0)->count();

                // Latest classes
                $data['recent_classes'] = ClassModel::latest()
                    ->limit(5)
                    ->get();
            }

            // =============================
            // Latest Students
            // =============================
            if ($studentsTable) {
                $createdCol = $this->firstExistingColumn(
                    $studentsTable,
                    ['created_at', 'createdAt', 'date', 'created_on']
                );

                $data['latest_students'] = DB::table($studentsTable)
                    ->when($createdCol, fn ($q) => $q->orderByDesc($createdCol))
                    ->limit(5)
                    ->get();
            }

            // =============================
            // Latest Results
            // =============================
            if ($resultsTable) {
                $createdCol = $this->firstExistingColumn(
                    $resultsTable,
                    ['created_at', 'createdAt', 'date', 'created_on']
                );

                $data['latest_results'] = DB::table($resultsTable)
                    ->when($createdCol, fn ($q) => $q->orderByDesc($createdCol))
                    ->limit(5)
                    ->get();
            }

        } catch (\Throwable $e) {
            // Keep defaults (dashboard never crashes)
        }

        return view('backend.admin.pages.dashboard', compact('data'));
    }

    /**
     * Return first table name that exists in DB
     */
    private function firstExistingTable(array $candidates): ?string
    {
        foreach ($candidates as $table) {
            if (Schema::hasTable($table)) {
                return $table;
            }
        }
        return null;
    }

    /**
     * Return first column name that exists for a given table
     */
    private function firstExistingColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $col) {
            if (Schema::hasColumn($table, $col)) {
                return $col;
            }
        }
        return null;
    }
}
