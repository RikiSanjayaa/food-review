<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
  /**
   * Show the email verification notice.
   */
  public function notice(Request $request)
  {
    return $request->user()->hasVerifiedEmail()
      ? redirect()->intended(route('recipes.index'))
      : view('auth.verify');
  }

  /**
   * Handle the email verification.
   */
  public function verify(EmailVerificationRequest $request)
  {
    $request->fulfill();

    return redirect()->route('recipes.index')->with('status', 'Email berhasil diverifikasi!');
  }

  /**
   * Resend the email verification notification.
   */
  public function resend(Request $request)
  {
    if ($request->user()->hasVerifiedEmail()) {
      return redirect()->route('recipes.index');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Link verifikasi telah dikirim ulang!');
  }
}
