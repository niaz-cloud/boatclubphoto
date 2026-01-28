<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('backend.admin.students.student_index', compact('students'));
    }

    public function create()
    {
        return view('backend.admin.students.student_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number',
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
        ]);

        $data['roll_number'] = trim($data['roll_number']);

        Student::create($data);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student added successfully');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('backend.admin.students.student_edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $data = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number,' . $student->id,
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
        ]);

        $data['roll_number'] = trim($data['roll_number']);

        $student->update($data);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();

        return back()->with('success', 'Student deleted successfully');
    }
}
