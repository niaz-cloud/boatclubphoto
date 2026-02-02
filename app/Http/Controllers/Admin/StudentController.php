<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $data = [];
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Student List';

        $students = Student::latest()->get();

        return view('backend.admin.students.student_index', compact('data', 'students'));
    }

    public function create()
    {
        $data = [];
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Add Student';

        return view('backend.admin.students.student_create', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number',
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
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

        return view('backend.admin.students.student_edit', compact('data', 'student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number,' . $student->id,
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
        ]);

        $validated['roll_number'] = trim($validated['roll_number']);

        $student->update($validated);

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
