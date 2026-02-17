<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * ✅ Attendance List (Filter by class/date)
     */
    public function index(Request $request)
    {
        $data = [];
        $data['active_menu'] = 'attendance';
        $data['page_title']  = 'Attendance List';

        $classes = ClassModel::orderBy('class_name')->get();

        $date    = $request->get('date', now()->toDateString());
        $classId = $request->get('class_id');

        $query = Attendance::with(['student', 'class'])
            ->whereDate('date', $date)
            ->orderBy('class_id')
            ->orderBy('student_id');

        if (!empty($classId)) {
            $query->where('class_id', $classId);
        }

        $rows = $query->get();

        return view('backend.admin.attendance.attendance_index', compact(
            'data', 'classes', 'rows', 'date', 'classId'
        ));
    }

    /**
     * ✅ Mark Attendance (Bulk for class/date)
     */
    public function create(Request $request)
    {
        $data = [];
        $data['active_menu'] = 'attendance';
        $data['page_title']  = 'Mark Attendance';

        $classes = ClassModel::orderBy('class_name')->get();

        $classId = $request->get('class_id');
        $date    = $request->get('date', now()->toDateString());

        $students = collect();
        $existing = collect();

        if (!empty($classId)) {
            $students = Student::where('class_id', $classId)
                ->orderBy('roll_number')
                ->get();

            // Existing attendance map → [student_id => status]
            $existing = Attendance::where('class_id', $classId)
                ->whereDate('date', $date)
                ->pluck('status', 'student_id');
        }

        return view('backend.admin.attendance.attendance_create', compact(
            'data', 'classes', 'students', 'existing', 'classId', 'date'
        ));
    }

    /**
     * ✅ Store Attendance (Duplicate-safe UPSERT)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date'     => 'required|date',
            'status'   => 'array',
            'status.*' => 'in:present,absent,late',
        ]);

        $classId = (int) $validated['class_id'];
        $date    = $validated['date'];

        $students = Student::where('class_id', $classId)
            ->select('id')
            ->get();

        DB::transaction(function () use ($students, $classId, $date, $request) {
            foreach ($students as $student) {

                $status = $request->input("status.{$student->id}", 'absent');

                Attendance::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'date'       => $date,
                    ],
                    [
                        'class_id' => $classId,
                        'status'   => $status,
                    ]
                );
            }
        });

        return redirect()
            ->route('admin.attendance.index', [
                'date'     => $date,
                'class_id' => $classId
            ])
            ->with('success', 'Attendance saved successfully.');
    }

    /**
     * 🎓 Student Attendance View
     */
  public function studentAttendance()
{
    if (auth()->user()->role !== 'student') {
        abort(403);
    }

    $user = auth()->user();

    // ✅ Find student linked to this user
    $student = Student::where('user_id', $user->id)->first();

    if (!$student) {
        abort(404, 'Student record not found');
    }

    // ✅ Use STUDENT ID (not USER ID)
    $attendance = Attendance::where('student_id', $student->id)
        ->orderBy('date', 'desc')
        ->get();

    return view('backend.student.attendance', compact('attendance'));
}

    /**
     * ✅ Edit Single Attendance Row
     */
    public function edit(Attendance $attendance)
    {
        $data = [];
        $data['active_menu'] = 'attendance';
        $data['page_title']  = 'Edit Attendance';

        return view('backend.admin.attendance.attendance_edit', compact('data', 'attendance'));
    }

    /**
     * ✅ Update Single Attendance Row
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance->update($validated);

        return redirect()
            ->route('admin.attendance.index', [
                'date'     => $attendance->date,
                'class_id' => $attendance->class_id
            ])
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * ✅ Delete Attendance Row
     */
    public function destroy(Attendance $attendance)
    {
        $date    = $attendance->date;
        $classId = $attendance->class_id;

        $attendance->delete();

        return redirect()
            ->route('admin.attendance.index', [
                'date'     => $date,
                'class_id' => $classId
            ])
            ->with('success', 'Attendance deleted successfully.');
    }
}
