<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Auth\UserRegistered;
use App\User;

class ActivationResendController extends Controller
{
    public function showResendForm()
    {
        return view('auth.activate.resend');
    }

    public function resend(Request $request)
    {
        $this->validateResendRequest($request);

        $user = User::byEmail($request->email)->first();

        event(new UserRegistered($user));

        return redirect()->route('login')
            ->withSuccess('Email activation has been resent.');
    }

    protected function validateResendRequest(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'This email is not exists. Please check your email.'
        ]);
    }
}
