<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // =========================================================
    // 👨‍💼 ADMIN PANEL LOGIC
    // =========================================================

  public function index()
{
    // 🛡 Permission Check
    if (!auth()->user()->can('view student')) {
        abort(403, 'Unauthorized');
    }

    $data['active_menu'] = 'students';
    $data['page_title']  = 'Student List';

    $students = Student::with('class')->latest()->get();

    return view('backend.admin.students.student_index', compact('data', 'students'));
}

    public function create()
{
    // 🛡 Permission Check
    if (!auth()->user()->can('create student')) {
        abort(403, 'Unauthorized');
    }

    $data['active_menu'] = 'students';
    $data['page_title']  = 'Add Student';

    $classes = ClassModel::orderBy('class_name')->get();

    return view('backend.admin.students.student_create', compact('data', 'classes'));
}


    /**
     * ✅ STORE STUDENT (USER + STUDENT)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'phone'       => 'nullable|string|max:20',
            'class_id'    => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($validated) {

            // ✅ Create User
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'student',
                'phone'    => $validated['phone'] ?? null,
            ]);

            // ✅ Create Student
            Student::create([
                'user_id'          => $user->id,
                'roll_number'      => trim($validated['roll_number']),
                'name'             => $validated['name'],
                'phone'            => $validated['phone'] ?? null,
                'class_id'         => $validated['class_id'],
                'attendance_count' => 0,
            ]);
        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student created successfully');
    }

    public function edit($id)
    {
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Edit Student';

        $student = Student::findOrFail($id);
        $classes = ClassModel::orderBy('class_name')->get();

        return view('backend.admin.students.student_edit', compact('data', 'student', 'classes'));
    }

    /**
     * ✅ UPDATE STUDENT + USER SYNC
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'roll_number' => 'required|string|max:50|unique:students,roll_number,' . $student->id,
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'required|email|unique:users,email,' . $student->user_id,
            'password'    => 'nullable|min:6|confirmed',
            'class_id'    => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($student, $validated) {

            // ✅ Update Student
            $student->update([
                'roll_number' => trim($validated['roll_number']),
                'name'        => $validated['name'],
                'phone'       => $validated['phone'],
                'class_id'    => $validated['class_id'],
            ]);

            // ✅ Update Linked User
            if ($student->user) {

                $student->user->update([
                    'name'  => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                ]);

                // ✅ Update Password ONLY if provided
                if (!empty($validated['password'])) {
                    $student->user->update([
                        'password' => Hash::make($validated['password'])
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }

    /**
     * ✅ STUDENT PROFILE (ADMIN VIEW)
     */
    public function show(Student $student)
    {
        $data['active_menu'] = 'students';
        $data['page_title']  = 'Student Profile';

        $attendanceQuery = Attendance::where('student_id', $student->id);

        $totalDays = $attendanceQuery->count();
        $present   = (clone $attendanceQuery)->where('status', 'present')->count();
        $late      = (clone $attendanceQuery)->where('status', 'late')->count();
        $absent    = (clone $attendanceQuery)->where('status', 'absent')->count();

        $percentage = $totalDays > 0
            ? round((($present + $late) / $totalDays) * 100, 2)
            : 0;

        $recentAttendance = Attendance::where('student_id', $student->id)
            ->latest('date')
            ->limit(10)
            ->get();

        $student->load(['results.exam', 'class', 'user']);

        return view(
            'backend.admin.students.student_profile',
            compact(
                'data',
                'student',
                'totalDays',
                'present',
                'late',
                'absent',
                'percentage',
                'recentAttendance'
            )
        );
    }

    /**
     * ✅ DELETE STUDENT + USER
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        DB::transaction(function () use ($student) {

            if ($student->user) {
                $student->user->delete();
            }

            $student->delete();
        });

        return back()->with('success', 'Student deleted successfully');
    }

    // =========================================================
    // 🎓 STUDENT PANEL LOGIC
    // =========================================================

    public function profile()
    {
        return view('backend.student.profile');
    }

    /**
     * ✅ UPDATE PROFILE (Student Panel)
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();

        DB::transaction(function () use ($request, $user) {

            // ✅ Update User
            $user->update([
                'name'  => $request->name,
                'phone' => $request->phone,
            ]);

            // ✅ Sync Student Table
            if ($user->student) {
                $user->student->update([
                    'name'  => $request->name,
                    'phone' => $request->phone,
                ]);
            }
        });

        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * ✅ UPDATE PASSWORD (Student Panel)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        // ✅ Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        // ✅ Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // 🔥 IMPORTANT → Force logout after password change
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Password updated successfully. Please login again.');
    }
}
