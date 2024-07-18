<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        return inertia('Auth/Login');
    }

    public function store(Request $request)
    {
        $result = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $attempt = Auth::attempt($result, true);

        if (!$attempt) {
            throw ValidationException::withMessages([
                'email' => 'Login attempt failed!'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/listing');
    }

    public function destory(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listing.index');
    }
}
