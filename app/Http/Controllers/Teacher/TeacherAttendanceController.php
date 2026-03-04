<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class TeacherAttendanceController extends Controller
{
    /**
     * Show attendance form
     */
    public function create(Student $student)
    {
        // Security check (Teacher can only access assigned students)
        $this->authorize('view', $student);

        return view('backend.teacher.teacher_attendance', compact('student'));
    }

    /**
     * Store attendance
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date'       => 'required|date',
            'status'     => 'required|in:present,absent',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Security check again
        $this->authorize('view', $student);

        Attendance::create([
            'student_id' => $student->id,
            'date'       => $request->date,
            'status'     => $request->status,
        ]);

        return redirect()
            ->route('teacher.students.show', $student->id)
            ->with('success', 'Attendance Added Successfully');
    }
}
