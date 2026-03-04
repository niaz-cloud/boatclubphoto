<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{

    public function index()
    {
        $data['active_menu'] = 'teachers';
        $data['page_title']  = 'Teacher List';

        $teachers = User::role('Teacher')->latest()->get();

        return view('backend.admin.teachers.teacher_index', compact('teachers', 'data'));
    }


    public function create()
    {
        $data['active_menu'] = 'teachers';
        $data['page_title']  = 'Add Teacher';

        return view('backend.admin.teachers.teacher_create', compact('data'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $teacher->assignRole('Teacher');

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Teacher created successfully');
    }


    public function edit($id)
    {
        $data['active_menu'] = 'teachers';
        $data['page_title']  = 'Edit Teacher';

        $teacher = User::findOrFail($id);

        return view('backend.admin.teachers.teacher_edit', compact('teacher', 'data'));
    }


    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $teacher->id
        ]);

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully');
    }


    public function destroy($id)
    {
        $teacher = User::findOrFail($id);

        $teacher->delete();

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully');
    }
}
