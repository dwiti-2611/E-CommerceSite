<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function index()
  {
    return view('content.authentications.auth-forgot-password-basic');
  }

  public function sendResetLinkEmail(Request $request)
  {
    // Validate the email address
    $validator = Validator::make($request->all(), [
      'email' => 'required|email|exists:users,email',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    // Attempt to send the password reset link
    $response = Password::sendResetLink($request->only('email'));

    // Check the response and return appropriate message
    if ($response == Password::RESET_LINK_SENT) {
      return redirect()
        ->back()
        ->with('status', trans($response));
    } else {
      return redirect()
        ->back()
        ->withErrors(['email' => trans($response)]);
    }
  }

  public function checkEmail(Request $request)
  {
    $emailExists = User::where('email', $request->email)->exists();
    return response()->json(['exists' => $emailExists]);
  }
}
