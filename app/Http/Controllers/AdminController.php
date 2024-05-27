<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  public function adminHome()
  {
    $emails = User::pluck('email')->toArray(); // Get all emails
    $adminId = auth()->id();
    $users = User::where('id', '!=', $adminId)->get();
    return view('content.admin.Home', compact('users', 'emails'))->with('i', (request()->input('page', 1) - 1) * 5);
  }
  /**
   * Display a listing of the resource.
   */
  public function profile()
  {
    $admin = auth()->user();
    return view('content.admin.Profile', compact('admin'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function updateProfile(Request $request)
  {
    $admin = auth()->user();
    $admin->update($request->all());
    return redirect()
      ->route('content.admin.profile')
      ->with('success', 'Profile updated successfully');
  }
  public function edit()
  {
    $emails = User::pluck('email')->toArray(); // Get all emails
    $admin = auth()->user();
    return view('content.admin.Edit', compact('admin', 'emails'));
  }
  public function update(Request $request, $id)
  {
    $admin = auth()->user();

    $request->validate([
      'name' => 'required|regex:/^[a-zA-Z\s]+$/',
      'email' => 'required|email|unique:users,email,' . $admin->id,
    ]);

    $admin->update($request->all());

    return redirect()
      ->route('admin.Profile', $admin->id)
      ->with('success', 'Profile updated successfully');
  }

  public function showChangePasswordForm()
  {
    return view('content.admin.ChangePassword');
  }

  public function changePassword(Request $request)
  {
    // Validate the request data
    $request->validate([
      'current_password' => 'required',
      'new_password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[a-zA-Z]).{8,}$/'],
      'new_password_confirmation' => 'required|same:new_password',
    ]);

    // Check if current password matches
    if (!Hash::check($request->current_password, Auth::user()->password)) {
      return back()->withErrors(['current_password' => 'Current password does not match']);
    }

    // Change the password
    Auth::user()->update([
      'password' => Hash::make($request->new_password),
    ]);

    return redirect('/admin/profile')->with('success', 'Password changed successfully');
  }
}
