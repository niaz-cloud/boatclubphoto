<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        $data['active_menu'] = 'classes';
        $data['page_title']  = 'Classes';

        $classes = ClassModel::latest()->paginate(10);

        return view('backend.admin.classes.classes_index', compact('classes', 'data'));
    }

    public function create()
    {
        $data['active_menu'] = 'classes';
        $data['page_title']  = 'Add Class';

        return view('backend.admin.classes.classes_create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:100',
            'class_code' => 'required|string|max:50|unique:classes,class_code',
        ]);

        ClassModel::create([
            'class_name'    => $request->class_name,
            'section'       => $request->section,
            'class_code'    => $request->class_code,
            'academic_year' => $request->academic_year,
            'description'   => $request->description,
            'status'        => $request->status ?? 1,
            'created_by'    => Auth::id(),
        ]);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully');
    }

    public function edit(ClassModel $class)
    {
        $data['active_menu'] = 'classes';
        $data['page_title']  = 'Edit Class';

        return view('backend.admin.classes.classes_edit', compact('class', 'data'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'class_name' => 'required|string|max:100',
            'class_code' => 'required|string|max:50|unique:classes,class_code,' . $class->id,
        ]);

        $class->update($request->all());

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();

        return back()->with('success', 'Class deleted successfully');
    }
}
