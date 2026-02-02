<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $data['active_menu'] = 'exams';
        $data['page_title']  = 'Exams';

        $exams = Exam::latest()->get();

        // ✅ changed to exam_index
        return view('backend.admin.exams.exam_index', compact('data', 'exams'));
    }

    public function create()
    {
        $data['active_menu'] = 'exams';
        $data['page_title']  = 'Add Exam';

        // ✅ changed to exam_create
        return view('backend.admin.exams.exam_create', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'total_question'     => 'required|integer|min:1',
            'per_question_mark'  => 'required|numeric|min:0',
            'negative_mark'      => 'nullable|numeric|min:0',
            'total_question_set' => 'required|integer|min:1',
            'pass_mark'          => 'required|numeric|min:0',
        ]);

        $validated['negative_mark'] = $validated['negative_mark'] ?? 0;

        // ✅ auto calculate total_mark
        $validated['total_mark'] =
            $validated['total_question'] * $validated['per_question_mark'];

        Exam::create($validated);

        return redirect()
            ->route('admin.exams.index')
            ->with('success', 'Exam added successfully!');
    }

    public function edit($id)
    {
        $data['active_menu'] = 'exams';
        $data['page_title']  = 'Edit Exam';

        $exam = Exam::findOrFail($id);

        // ✅ already correct (exam_edit)
        return view('backend.admin.exams.exam_edit', compact('data', 'exam'));
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'total_question'     => 'required|integer|min:1',
            'per_question_mark'  => 'required|numeric|min:0',
            'negative_mark'      => 'nullable|numeric|min:0',
            'total_question_set' => 'required|integer|min:1',
            'pass_mark'          => 'required|numeric|min:0',
        ]);

        $validated['negative_mark'] = $validated['negative_mark'] ?? 0;

        // ✅ auto calculate total_mark again
        $validated['total_mark'] =
            $validated['total_question'] * $validated['per_question_mark'];

        $exam->update($validated);

        return redirect()
            ->route('admin.exams.index')
            ->with('success', 'Exam updated successfully!');
    }

    public function destroy($id)
    {
        Exam::findOrFail($id)->delete();

        return back()->with('success', 'Exam deleted successfully!');
    }
}
