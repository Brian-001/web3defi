<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request){
        //Triger laravel notify success notification
        notify()->success('Login successful');

        //Default Fortify behaviour redirect to home or return JSON for XHR
        return $request->wantsJson()
            ? new JsonResponse(['message' => 'Login successful'], 204)
            : redirect()->intended(config('fortify.home'));
    }
}