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
        $exams = Exam::latest()->paginate(10);
        return view('backend.admin.exams.index', compact('data', 'exams'));
    }

    public function create()
    {
        $data['active_menu'] = 'exams';
        return view('backend.admin.exams.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_question' => 'required|integer|min:1',
            'per_question_mark' => 'required|numeric|min:0',
            'negative_mark' => 'nullable|numeric|min:0',
            'total_question_set' => 'required|integer|min:1',
            'pass_mark' => 'required|numeric|min:0',
        ]);

        $validated['negative_mark'] = $validated['negative_mark'] ?? 0;

        // ✅ auto calculate total_mark
        $validated['total_mark'] = $validated['total_question'] * $validated['per_question_mark'];

        Exam::create($validated);

        return redirect()->route('admin.exams.index')->with('success', 'Exam added successfully!');
    }
}
