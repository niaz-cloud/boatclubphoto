<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceReportController extends Controller
{
    /**
     * Show attendance report with date range filter
     */
    public function index(Request $request)
    {
        $data['active_menu'] = 'attendance';
        $data['page_title']  = 'Attendance Report';

        $classes = ClassModel::orderBy('class_name')->get();

        $from    = $request->from_date;
        $to      = $request->to_date;
        $classId = $request->class_id;

        $rows = collect();

        if ($from && $to) {
            $query = Attendance::with(['student', 'class'])
                ->whereBetween('date', [$from, $to]);

            if (!empty($classId)) {
                $query->where('class_id', $classId);
            }

            $rows = $query->orderBy('date')->get();
        }

        return view('backend.admin.attendance.attendance_report', compact(
            'data', 'classes', 'rows', 'from', 'to', 'classId'
        ));
    }

    /**
     * Export attendance report as CSV (Excel compatible)
     */
    public function exportCsv(Request $request)
    {
        $rows = Attendance::with(['student', 'class'])
            ->whereBetween('date', [$request->from_date, $request->to_date])
            ->when($request->class_id, fn ($q) => $q->where('class_id', $request->class_id))
            ->orderBy('date')
            ->get();

        $filename = 'attendance_report.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');

            // CSV header
            fputcsv($file, ['Date', 'Class', 'Roll', 'Student', 'Status']);

            foreach ($rows as $row) {
                fputcsv($file, [
                    $row->date,
                    $row->class->class_name ?? '-',
                    $row->student->roll_number ?? '',
                    $row->student->name ?? '-',
                    ucfirst($row->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export attendance report as PDF
     */
    public function exportPdf(Request $request)
    {
        $rows = Attendance::with(['student', 'class'])
            ->whereBetween('date', [$request->from_date, $request->to_date])
            ->when($request->class_id, fn ($q) => $q->where('class_id', $request->class_id))
            ->orderBy('date')
            ->get();

        $pdf = Pdf::loadView(
            'backend.admin.attendance.attendance_report_pdf',
            compact('rows')
        );

        return $pdf->download('attendance_report.pdf');
    }
}
