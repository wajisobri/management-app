<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomEmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmailVerificationController extends Controller
{
    public function verify()
    {
        if (!Session::has('email') && !Session::has('id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    public function doVerify(CustomEmailVerificationRequest $request)
    {
        // Find the user and mark email as verified
        $user = User::findOrFail($request->route('id'));
        $user->markEmailAsVerified();

        // Send event after email verification
        event(new Verified($user));

        return redirect()->route('login')->with('success', 'Email verified.');
    }

    public function doResend(Request $request)
    {
        // Resend the email verification link
        $user = User::findOrFail($request->id);
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Email verification link sent.');
    }
}
