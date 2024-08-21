<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        try {
            // Check if user is verified
            if (User::where('email', $request->email)->whereNull('email_verified_at')->exists()) {
                return redirect()->route('verification.notice')->with([
                    'id' => User::where('email', $request->email)->first()->id,
                    'email' => $request->email,
                ]);
            }

            // Try to login with email and password
            if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
                return redirect()->back()->with('error', 'Invalid email or password.');
            }

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to login.');
        }
    }

    public function destroy()
    {
        try {
            // Try to logout user
            Auth::logout();

            return redirect()->route('login');
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to logout.');
        }
    }
}
