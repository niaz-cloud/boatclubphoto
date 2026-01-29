<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $data = [];
        $data['active_menu'] = 'profile';
        $data['page_title']  = 'Profile';

        $user = Auth::user();

        return view('backend.admin.pages.profile', compact('data', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        // Upload photo (optional)
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/users'), $filename);

            // Save path or filename (choose one style)
            $user->photo = 'uploads/users/' . $filename;
        }

        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
