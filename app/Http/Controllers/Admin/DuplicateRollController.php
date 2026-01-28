<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DuplicateRoll;
use App\Models\Exam;
use Illuminate\Http\Request;

class DuplicateRollController extends Controller
{
    public function index()
    {
        $data['active_menu'] = 'duplicate_rolls';

        $duplicateRolls = DuplicateRoll::with('exam')
            ->latest()
            ->paginate(10);

        return view('backend.admin.duplicate_rolls.index', compact('data', 'duplicateRolls'));
    }

    public function create()
    {
        $data['active_menu'] = 'duplicate_rolls';
        $exams = Exam::orderBy('id', 'desc')->get();

        return view('backend.admin.duplicate_rolls.create', compact('data', 'exams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'roll_number' => 'required|string|max:50',
        ]);

        // stop duplicates for same exam (matches unique constraint)
        $exists = DuplicateRoll::where('exam_id', $validated['exam_id'])
            ->where('roll_number', $validated['roll_number'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'This roll number already exists for this exam.');
        }

        DuplicateRoll::create($validated);

        return redirect()->route('admin.duplicate-rolls.index')
            ->with('success', 'Duplicate roll added successfully!');
    }

    public function destroy(DuplicateRoll $duplicate_roll)
    {
        $duplicate_roll->delete();
        return back()->with('success', 'Duplicate roll deleted successfully!');
    }
}
