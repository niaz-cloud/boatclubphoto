<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Attendance;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $data = [];
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Student List';

        $students = Student::with('class')->latest()->get();

        return view('backend.admin.students.student_index', compact('data', 'students'));
    }

    public function create()
    {
        $data = [];
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Add Student';

        $classes = ClassModel::orderBy('class_name')->get();

        return view('backend.admin.students.student_create', compact('data', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number',
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'class_id'    => 'required|exists:classes,id',
        ]);

        $validated['roll_number'] = trim($validated['roll_number']);

        Student::create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student added successfully');
    }

    public function edit($id)
    {
        $data = [];
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Edit Student';

        $student = Student::findOrFail($id);
        $classes = ClassModel::orderBy('class_name')->get();

        return view('backend.admin.students.student_edit', compact('data', 'student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number,' . $student->id,
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'class_id'    => 'required|exists:classes,id',
        ]);

        $validated['roll_number'] = trim($validated['roll_number']);

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }

    /**
     * ✅ Student Profile Page
     */
    public function show(Student $student)
    {
        $data = [];
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Student Profile';

        /**
         * =====================
         * Attendance Statistics
         * =====================
         */
        $attendanceQuery = Attendance::where('student_id', $student->id);

        $totalDays = $attendanceQuery->count();
        $present   = (clone $attendanceQuery)->where('status', 'present')->count();
        $late      = (clone $attendanceQuery)->where('status', 'late')->count();
        $absent    = (clone $attendanceQuery)->where('status', 'absent')->count();

        $percentage = $totalDays > 0
            ? round((($present + $late) / $totalDays) * 100, 2)
            : 0;

        $recentAttendance = Attendance::where('student_id', $student->id)
            ->orderByDesc('date')
            ->limit(10)
            ->get();

        /**
         * =====================
         * Results (via roll_number)
         * =====================
         */
        $student->load([
            'results.exam',   // 👈 IMPORTANT
            'class'
        ]);

        return view(
            'backend.admin.students.student_profile',
            compact(
                'data',
                'student',
                'totalDays',
                'present',
                'late',
                'absent',
                'percentage',
                'recentAttendance'
            )
        );
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return back()->with('success', 'Student deleted successfully');
    }
}
