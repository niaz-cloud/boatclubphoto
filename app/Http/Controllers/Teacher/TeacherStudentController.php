<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class TeacherStudentController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        $students = $teacher->students()->with('class')->get();

        return view('backend.teacher.teacher_students', compact('students'));
    }

    public function show($id)
    {
        $teacher = Auth::user();

        $student = $teacher->students()
            ->where('id', $id)
            ->with(['class', 'results'])
            ->firstOrFail();

        // Attendance counts
        $present = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();

        $late = Attendance::where('student_id', $student->id)
            ->where('status', 'late')
            ->count();

        $absent = Attendance::where('student_id', $student->id)
            ->where('status', 'absent')
            ->count();

        $total = $present + $late + $absent;

        $percentage = $total > 0 ? round((($present + $late) / $total) * 100) : 0;

        $recentAttendance = Attendance::where('student_id', $student->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('backend.admin.students.student_profile', compact(
            'student',
            'present',
            'late',
            'absent',
            'percentage',
            'recentAttendance'
        ));
    }
}
