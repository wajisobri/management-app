<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Send event after user registration to send email verification
            event(new Registered($user));

            DB::commit();

            return redirect()->route('login')->with('success', 'Your account has been created.');
        } catch (\Exception $e) {
            // Rollback database transaction
            DB::rollBack();

            Log::error('User registration failed: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Failed to create account.']);
        }
    }
}
