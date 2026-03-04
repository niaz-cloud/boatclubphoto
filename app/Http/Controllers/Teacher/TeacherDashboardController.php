<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Result;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        $students = $teacher->students()->with('class')->get();

        $totalStudents = $students->count();

        $todayAttendance = Attendance::whereIn(
            'student_id',
            $students->pluck('id')
        )->whereDate('date', today())->count();

        $totalResults = Result::whereIn(
            'student_id',
            $students->pluck('id')
        )->count();

        return view('backend.teacher.teacher_dashboard', compact(
            'students',
            'totalStudents',
            'todayAttendance',
            'totalResults'
        ));
    }
}
