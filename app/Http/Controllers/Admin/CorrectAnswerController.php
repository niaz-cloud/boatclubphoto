<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorrectAnswer;
use App\Models\Exam;
use Illuminate\Http\Request;

class CorrectAnswerController extends Controller
{
    public function index(Request $request)
    {
        $data['active_menu'] = 'correct_answers';
        $exams = Exam::orderBy('id', 'desc')->get();

        $query = CorrectAnswer::with('exam')->latest();

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('set_number')) {
            $query->where('set_number', trim($request->set_number));
        }

        $answers = $query->paginate(30)->withQueryString();

        return view('backend.admin.correct_answers.correct_answer_index', compact('data', 'answers', 'exams'));
    }

    public function create()
    {
        $data['active_menu'] = 'correct_answers';
        $exams = Exam::orderBy('id', 'desc')->get();

        return view('backend.admin.correct_answers.correct_answer_create', compact('data', 'exams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'set_number' => 'required|string|max:20',
            'question_number' => 'required|integer|min:1',
            'student_option' => 'required|string|max:10',
        ]);

        $validated['set_number'] = trim($validated['set_number']);
        $validated['student_option'] = strtoupper(trim($validated['student_option']));

        // ✅ upsert (create or update same exam+set+question)
        CorrectAnswer::updateOrCreate(
            [
                'exam_id' => $validated['exam_id'],
                'set_number' => $validated['set_number'],
                'question_number' => $validated['question_number'],
            ],
            [
                'student_option' => $validated['student_option'],
            ]
        );

        return redirect()->route('admin.correct_answers.index')->with('success', 'Answer saved successfully!');
    }

    public function destroy(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->delete();
        return back()->with('success', 'Answer deleted.');
    }
}
