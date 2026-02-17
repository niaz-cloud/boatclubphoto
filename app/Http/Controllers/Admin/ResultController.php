<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Exam;
use App\Models\DuplicateRoll;
use App\Models\OmrError;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $data = [];
        $data['active_menu'] = 'results';
        $data['page_title']  = 'Results';

        $results = Result::with(['exam', 'student'])
            ->latest()
            ->paginate(10);

        $duplicateMap = DuplicateRoll::select('exam_id', 'roll_number')
            ->get()
            ->groupBy('exam_id')
            ->map(fn($rows) => $rows->pluck('roll_number')->toArray())
            ->toArray();

        return view('backend.admin.results.result_index', compact('data', 'results', 'duplicateMap'));
    }

    public function create()
    {
        $data = [];
        $data['active_menu'] = 'results';
        $data['page_title']  = 'Add Result';

        $exams = Exam::orderBy('id', 'desc')->get();

        return view('backend.admin.results.result_create', compact('data', 'exams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id'         => 'required|exists:exams,id',
            'roll_number'     => 'required|string|max:50',
            'correct_answer'  => 'required|integer|min:0',
            'wrong_answer'    => 'required|integer|min:0',
        ]);

        $validated['roll_number'] = trim($validated['roll_number']);

        $examId = $validated['exam_id'];
        $roll   = $validated['roll_number'];

        // 🚫 Duplicate roll check
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

        // 🚫 Prevent double result
        if (Result::where('exam_id', $examId)
            ->where('roll_number', $roll)
            ->exists()) {

            return back()->withInput()->with('error', 'Result already exists for this roll.');
        }

        // ✅ Find student via roll number
        $student = Student::where('roll_number', $roll)->first();

        if (!$student) {
            return back()->withInput()->with('error', 'Student not found with this roll number.');
        }

        $exam = Exam::findOrFail($examId);

        $obtained = ($validated['correct_answer'] * $exam->per_question_mark)
                  - ($validated['wrong_answer'] * $exam->negative_mark);

        if ($obtained < 0) {
            $obtained = 0;
        }

        $status = $obtained >= $exam->pass_mark ? 'pass' : 'fail';

        // ✅ Save Result with student_id
        Result::create([
            'exam_id'         => $examId,
            'student_id'      => $student->id,  // ✅ CRITICAL FIX
            'roll_number'     => $roll,
            'correct_answer'  => $validated['correct_answer'],
            'wrong_answer'    => $validated['wrong_answer'],
            'obtained_mark'   => $obtained,
            'total_mark'      => $exam->total_mark,
            'pass_mark'       => $exam->pass_mark,
            'status'          => $status,
        ]);

        return redirect()
            ->route('admin.results.index')
            ->with('success', 'Result generated successfully!');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        return back()->with('success', 'Result deleted.');
    }

    // 🎓 Student Results
   public function studentResults()
{
    $student = auth()->user()->student;

    if (!$student) {
        abort(404, 'Student record not found');
    }

    $results = Result::where('student_id', $student->id) // ✅ FIXED
        ->with('exam')
        ->latest()
        ->get();

    return view('backend.student.results', compact('results'));
}
}
