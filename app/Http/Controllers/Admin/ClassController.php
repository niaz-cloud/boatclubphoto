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
        $data = [];
        $data['active_menu'] = 'classes';
        $data['page_title']  = 'Classes';

        // ✅ DataTable needs full collection (not paginate)
        $classes = ClassModel::latest()->get();

        return view('backend.admin.classes.classes_index', compact('classes', 'data'));
    }

    public function create()
    {
        $data = [];
        $data['active_menu'] = 'classes';
        $data['page_title']  = 'Add Class';

        return view('backend.admin.classes.classes_create', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name'    => 'required|string|max:100',
            'section'       => 'nullable|string|max:100',
            'class_code'    => 'required|string|max:50|unique:classes,class_code',
            'academic_year' => 'nullable|string|max:50',
            'description'   => 'nullable|string',
            'status'        => 'nullable|in:0,1',
        ]);

        $validated['class_code'] = trim($validated['class_code']);
        $validated['status'] = $validated['status'] ?? 1;
        $validated['created_by'] = Auth::id();

        ClassModel::create($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Class created successfully');
    }

    public function edit(ClassModel $class)
    {
        $data = [];
        $data['active_menu'] = 'classes';
        $data['page_title']  = 'Edit Class';

        return view('backend.admin.classes.classes_edit', compact('class', 'data'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'class_name'    => 'required|string|max:100',
            'section'       => 'nullable|string|max:100',
            'class_code'    => 'required|string|max:50|unique:classes,class_code,' . $class->id,
            'academic_year' => 'nullable|string|max:50',
            'description'   => 'nullable|string',
            'status'        => 'nullable|in:0,1',
        ]);

        $validated['class_code'] = trim($validated['class_code']);
        $validated['status'] = $validated['status'] ?? $class->status;

        $class->update($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Class updated successfully');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();

        return back()->with('success', 'Class deleted successfully');
    }
}
