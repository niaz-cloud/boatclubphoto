<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AuditorController extends Controller
{
    public function index()
    {
        $auditors = Auditor::latest()->get();
        return view('backend.admin.auditors.auditor_index', compact('auditors'));
    }

    public function create()
    {
        return view('backend.admin.auditors.auditor_create');
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email|unique:auditors,email',
            'phone'  => 'nullable|string|max:20',
            'status' => 'required|in:0,1',
            'photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['status'] = (int) $data['status'];

        if ($request->hasFile('photo')) {
            $dir = public_path('uploads/auditors');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);

            $data['photo'] = $filename;
        }

        Auditor::create($data);

        return redirect()->route('admin.auditors.index')
            ->with('success', 'Auditor added successfully');
    }

    public function edit($id)
    {
        $auditor = Auditor::findOrFail($id);
        return view('backend.admin.auditors.auditor_edit', compact('auditor'));
    }

    public function update(Request $request, $id)
    {
        $auditor = Auditor::findOrFail($id);

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email|unique:auditors,email,' . $auditor->id,
            'phone'  => 'nullable|string|max:20',
            'status' => 'required|in:0,1',
            'photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['status'] = (int) $data['status'];

        if ($request->hasFile('photo')) {
            $dir = public_path('uploads/auditors');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            if ($auditor->photo) {
                $oldPath = $dir . DIRECTORY_SEPARATOR . $auditor->photo;
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);

            $data['photo'] = $filename;
        }

        $auditor->update($data);

        return redirect()->route('admin.auditors.index')
            ->with('success', 'Auditor updated successfully');
    }

    public function destroy($id)
    {
        $auditor = Auditor::findOrFail($id);

        if ($auditor->photo) {
            $path = public_path('uploads/auditors/' . $auditor->photo);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $auditor->delete();

        return back()->with('success', 'Auditor deleted successfully');
    }
}
