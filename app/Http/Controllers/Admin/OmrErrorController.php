<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OmrError;
use App\Models\Exam;
use Illuminate\Http\Request;

class OmrErrorController extends Controller
{
    public function index(Request $request)
    {
        $data['active_menu'] = 'omr_errors';

        $exams = Exam::orderBy('id', 'desc')->get();

        $query = OmrError::with('exam')->latest();

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('roll_number')) {
            $query->where('roll_number', 'like', '%' . trim($request->roll_number) . '%');
        }

        if ($request->filled('set_number')) {
            $query->where('set_number', trim($request->set_number));
        }

        $errors = $query->paginate(20)->withQueryString();

        return view(
            'backend.admin.omr_errors.omr_error_index',
            compact('data', 'errors', 'exams')
        );
    }

    public function destroy(OmrError $omrError)
    {
        $omrError->delete();

        return back()->with('success', 'OMR error deleted successfully.');
    }
}
