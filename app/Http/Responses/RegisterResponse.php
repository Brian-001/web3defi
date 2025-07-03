<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        // Trigger laravel-notify success notification
        notify()->success('Registration successful');

        // Default Fortify behavior: redirect to home or return JSON for XHR
        return $request->wantsJson()
            ? new JsonResponse(['message' => 'Registration successful'], 201)
            : redirect()->intended(config('fortify.home'));
    }
}