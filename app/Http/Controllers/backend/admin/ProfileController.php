<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PDOException;

class ProfileController extends Controller
{
    /**
     * =========================
     * 👑 ADMIN PROFILE
     * =========================
     */
    public function profile(Request $request)
    {
        $data = [];
        $data['active_menu'] = 'Profile';
        $data['page_title']  = 'Profile';

        return view('backend.admin.pages.profile', compact('data'));
    }

    public function profile_info_update(Request $request)
    {
        $id = Auth::id();
        $current_user = User::findOrFail($id);
        $user_photo   = $current_user->photo;

        try {
            if ($request->hasFile('photo')) {

                $image_extension = $request->file('photo')->extension();
                $image_name = 'backend_assets/images/user/' . uniqid() . '.' . $image_extension;

                $request->file('photo')->move('backend_assets/images/user', $image_name);

                // delete old photo if exists
                if (!empty($user_photo) && File::exists($user_photo)) {
                    File::delete($user_photo);
                }

            } else {
                $image_name = $user_photo;
            }

            $current_user->update([
                'name'  => $request->name,
                'photo' => $image_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return back()->with('success', 'Profile updated successfully');

        } catch (PDOException $e) {
            return back()->with('error', 'Update failed. Please try again.');
        }
    }

    public function profile_password_update(Request $request)
    {
        $id = Auth::id();
        $current_user = User::findOrFail($id);

        $request->validate([
            'password' => 'required|confirmed',
        ], [
            'password.required'  => 'Enter a password',
            'password.confirmed' => 'Passwords do not match',
        ]);

        try {
            $current_user->update([
                'password' => bcrypt($request->password)
            ]);

            return back()->with('success', 'Password updated successfully');

        } catch (PDOException $e) {
            return back()->with('error', 'Password update failed');
        }
    }

    /**
     * =========================
     * 🎓 STUDENT PROFILE
     * =========================
     */
    public function studentProfile()
    {
        $data = [];
        $data['page_title'] = 'My Profile';

        return view('backend.student.profile', compact('data'));
    }

    public function studentProfileUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile updated successfully');
    }
}
