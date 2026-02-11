<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AccountActivationController extends Controller
{
    public function showActivationForm($token)
    {
        $user = User::where('activation_token', $token)
            ->where('activation_token_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->route('employee.login')
                ->with('error', 'Invalid or expired activation link.');
        }

        return view('auth.activate', compact('token', 'user'));
    }

    public function activate(Request $request, $token)
    {
        $user = User::where('activation_token', $token)
            ->where('activation_token_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->route('employee.login')
                ->with('error', 'Invalid or expired activation link.');
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
            'account_activated' => true,
            'activation_token' => null,
            'activation_token_expires_at' => null,
            'status' => 'active',
        ]);

        return redirect()->route('employee.login')
            ->with('success', 'Account activated successfully! You can now login with your credentials.');
    }
}
