<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'employee_number';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'employee_number' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    // Optionally, you can customize the login method if needed
    protected function attemptLogin(Request $request)
    {
        return Auth::attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    // Customize credentials method to handle employee_number
    protected function credentials(Request $request)
    {
        return [
            'employee_number' => $request->{$this->username()},
            'password' => $request->password,
        ];
    }
}
