<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;

class TwoFactorChallengeController extends Controller
{
    public function show()
    {
        return view('auth.two-factor-challenge');
    }

    public function store(Request $request, ConfirmTwoFactorAuthentication $confirm)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = Auth::user() ?? (session('login.id') ? \App\Models\User::find(session('login.id')) : null);

        if (!$user) {
            throw ValidationException::withMessages([
                'code' => [__('No user found.')],
            ]);
        }

        // Confirm the 2FA code using Fortify’s action
        $confirm($user, $request->code);

        // Log in the user
        Auth::login($user);

        return app(LoginResponse::class);
    }
}