<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Result;
use App\Models\Exam;
use Illuminate\Http\Request;

class TeacherResultController extends Controller
{
    /**
     * Show result form
     */
    public function create(Student $student)
    {
        $this->authorize('view', $student);

        $exams = Exam::all();

        return view('backend.teacher.results.create', compact('student', 'exams'));
    }

    /**
     * Store result
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_id' => 'required|exists:exams,id',
            'marks' => 'required|numeric|min:0',
            'grade' => 'required|string|max:10',
        ]);

        $student = Student::findOrFail($request->student_id);

        $this->authorize('view', $student);

        Result::create([
            'student_id' => $student->id,
            'exam_id' => $request->exam_id,
            'marks' => $request->marks,
            'grade' => $request->grade,
        ]);

        return redirect()
            ->route('teacher.students.show', $student->id)
            ->with('success', 'Result Added Successfully');
    }
}
