<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Student List';

        // 🔒 Admin sees all students (later we can restrict per admin)
        $students = Student::with('class')->latest()->get();

        return view('backend.admin.students.student_index', compact('data', 'students'));
    }

    public function create()
    {
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Add Student';

        $classes = ClassModel::orderBy('class_name')->get();

        return view('backend.admin.students.student_create', compact('data', 'classes'));
    }

    /**
     * ✅ CREATE STUDENT (USER + STUDENT)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'phone'       => 'nullable|string|max:20',
            'class_id'    => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($validated) {

    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role'     => 'student',
    ]);

    Student::create([
        'user_id'          => $user->id, // 🔥 must exist
        'roll_number'      => trim($validated['roll_number']),
        'name'             => $validated['name'],
        'phone'            => $validated['phone'] ?? null,
        'class_id'         => $validated['class_id'],
        'attendance_count' => 0,
    ]);
});


        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student created successfully');
    }

    public function edit($id)
    {
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

        $student->update([
            'roll_number' => trim($validated['roll_number']),
            'name'        => $validated['name'],
            'phone'       => $validated['phone'],
            'class_id'    => $validated['class_id'],
        ]);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }

    /**
     * ✅ Student Profile (Admin View)
     */
    public function show(Student $student)
    {
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Student Profile';

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

        $student->load(['results.exam', 'class']);

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
