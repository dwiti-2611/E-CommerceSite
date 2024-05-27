<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index()
  {
    return view('content.authentications.Login');
  }

  public function login(Request $request): RedirectResponse
  {
    $input = $request->only('email', 'password');

    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required',
    ]);

    // Check if the email exists in the database
    $userExists = \App\Models\User::where('email', $input['email'])->exists();

    if (!$userExists) {
      return redirect()
        ->back()
        ->withErrors(['email' => 'The email address is not registered.'])
        ->withInput($request->only('email'));
    }

    if (Auth::attempt($input)) {
      $user = Auth::user();

      if ($user->type == 'admin') {
        return redirect()
          ->route('admin.Home')
          ->with('success', 'You have logged in successfully!');
      } else {
        return redirect()
          ->route('user.Home')
          ->with('success', 'You have logged in successfully!');
      }
    } else {
      return redirect()
        ->back()
        ->withErrors(['password' => 'The password is incorrect.'])
        ->withInput($request->only('email'));
    }
  }

  public function logout()
  {
    Session::flush();
    Auth::logout();
    return redirect('/');
  }
}
