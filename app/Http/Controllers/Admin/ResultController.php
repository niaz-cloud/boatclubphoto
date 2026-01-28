<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Exam;
use App\Models\DuplicateRoll;
use App\Models\OmrError; // ✅ ADDED
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $data['active_menu'] = 'results';

        $results = Result::with('exam')->latest()->paginate(10);

        $duplicateMap = DuplicateRoll::select('exam_id', 'roll_number')
            ->get()
            ->groupBy('exam_id')
            ->map(fn($rows) => $rows->pluck('roll_number')->toArray())
            ->toArray();

        return view('backend.admin.results.result_index', compact('data', 'results', 'duplicateMap'));
    }

    public function create()
    {
        $data['active_menu'] = 'results';
        $exams = Exam::orderBy('id', 'desc')->get();

        return view('backend.admin.results.result_create', compact('data', 'exams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'roll_number' => 'required|string|max:50',
            'correct_answer' => 'required|integer|min:0',
            'wrong_answer' => 'required|integer|min:0',
        ]);

        // normalize
        $validated['roll_number'] = trim($validated['roll_number']);

        $examId = $validated['exam_id'];
        $roll = $validated['roll_number'];

        // 🚫 Block duplicate roll (and log in omr_errors)
        if (DuplicateRoll::where('exam_id', $examId)
            ->where('roll_number', $roll)
            ->exists()) {

            OmrError::create([
                'exam_id'     => $examId,
                'file_path'   => 'manual_entry',
                'roll_number' => $roll,
                'set_number'  => null,
                'message'     => 'Duplicate roll number for this exam.',
            ]);

            return back()->withInput()->with('error', 'Duplicate roll number for this exam.');
        }

        // 🚫 Prevent double result (and log in omr_errors)
        if (Result::where('exam_id', $examId)
            ->where('roll_number', $roll)
            ->exists()) {

            OmrError::create([
                'exam_id'     => $examId,
                'file_path'   => 'manual_entry',
                'roll_number' => $roll,
                'set_number'  => null,
                'message'     => 'Result already exists for this roll.',
            ]);

            return back()->withInput()->with('error', 'Result already exists for this roll.');
        }

        $exam = Exam::findOrFail($examId);

        $obtained = ($validated['correct_answer'] * $exam->per_question_mark)
                  - ($validated['wrong_answer'] * $exam->negative_mark);

        if ($obtained < 0) $obtained = 0;

        $status = $obtained >= $exam->pass_mark ? 'pass' : 'fail';

        Result::create([
            'exam_id' => $examId,
            'roll_number' => $roll,
            'correct_answer' => $validated['correct_answer'],
            'wrong_answer' => $validated['wrong_answer'],
            'obtained_mark' => $obtained,
            'total_mark' => $exam->total_mark,
            'pass_mark' => $exam->pass_mark,
            'status' => $status,
        ]);

        return redirect()->route('admin.results.index')->with('success', 'Result generated successfully!');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        return back()->with('success', 'Result deleted.');
    }
}
