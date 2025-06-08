<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TwoFactorAuthenticationController extends Controller
{
    //
    public function destroy(Request $request)
    {
        $user = $request->user();

        Log::info('Disabling 2FA for user ID: ' . $user->id);

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        Log::info('2FA disabled, two_factor_confirmed_at set to: ' . ($user->two_factor_confirmed_at ? $user->two_factor_confirmed_at : 'null'));

        return redirect()->route('dashboard.profile')->with('success', 'Two-factor authentication disabled.');
    }
}
