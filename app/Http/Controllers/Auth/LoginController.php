<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // HR/Admin Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Employee Login Form
    public function showEmployeeLoginForm()
    {
        return view('auth.employee-login');
    }

    // HR/Admin Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = auth()->user();
            
            // Only allow HR/Admin roles
            if ($user->hasRole(['super-admin', 'admin', 'hr'])) {
                return redirect()->intended(route('dashboard'));
            }
            
            // If employee tries to login via HR portal, logout and redirect
            Auth::logout();
            return redirect()->route('employee.login')->with('error', 'Please use the Employee login page.');
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    // Employee Login
    public function employeeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = auth()->user();
            
            // Check if account is activated
            if (!$user->account_activated) {
                Auth::logout();
                return back()->with('error', 'Your account is not activated yet. Please check your email for the activation link.');
            }
            
            // Only allow employee role
            if ($user->hasRole('employee')) {
                return redirect()->intended(route('employee.dashboard'));
            }
            
            // If HR/Admin tries to login via employee portal, logout and redirect
            Auth::logout();
            return redirect()->route('login')->with('error', 'Please use the HR/Admin login page.');
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function logout(Request $request)
    {
        $wasEmployee = auth()->user()->hasRole('employee');
        
        Auth::logout();
        
        if ($request->session()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        // Redirect to appropriate login page
        if ($wasEmployee) {
            return redirect()->route('employee.login')->with('success', 'You have been logged out successfully.');
        }
        
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
