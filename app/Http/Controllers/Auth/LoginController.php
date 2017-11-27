<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => [ //Make an custom array
                'required','string',
                Rule::exists('users')->where(function ($query) { //create closure with query builder to check the users
                    $query->where('active', true); //where active column is true
                })
            ],
            'password' => 'required|string',
        ], $this->validationErrors());
    }

    /**
     * Get the validation errors for login.
     *
     * @return array
     */
    public function validationErrors()
    {
        return [
            $this->username() . '.exists' => 'The selected email is invalid or you need to activate your account.'
        ];
    }
}
