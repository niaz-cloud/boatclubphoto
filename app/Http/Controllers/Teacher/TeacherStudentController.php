<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $student = $teacher->students()->where('id', $id)->with('class')->firstOrFail();

        return view('backend.teacher.students.show', compact('student'));
    }
}
