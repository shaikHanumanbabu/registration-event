<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  /**
   * Show admin login form
   */
  public function showLoginForm()
  {
    return view('admin.login');
  }

  /**
   * Handle admin login
   */
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    // Attempt to authenticate using admin guard
    if (Auth::guard('admin')->attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
  }

  /**
   * Show admin dashboard
   */
  public function dashboard()
  {
    $registrations = Registration::orderBy('created_at', 'desc')->paginate(10);
    return view('admin.dashboard', compact('registrations'));
  }

  /**
   * Verify payment for a registration
   */
  public function verifyPayment($id)
  {
    try {
      $registration = Registration::findOrFail($id);
      $registration->update([
        'payment_status' => 'verified',
        'checked_in' => 0,
        'checked_in_at' => null
      ]);

      return back()->with('success', 'Payment verified successfully for ' . $registration->name);
    } catch (\Exception $e) {
      return back()->with('error', 'Failed to verify payment: ' . $e->getMessage());
    }
  }

  /**
   * Unverify payment for a registration
   */
  public function unverifyPayment($id)
  {
    try {
      $registration = Registration::findOrFail($id);
      $registration->update(['payment_status' => 'non-verified']);

      return back()->with('success', 'Payment status reverted for ' . $registration->name);
    } catch (\Exception $e) {
      return back()->with('error', 'Failed to update payment status: ' . $e->getMessage());
    }
  }

  /**
   * Handle admin logout
   */
  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
  }
}
