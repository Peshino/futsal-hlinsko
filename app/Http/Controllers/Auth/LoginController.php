<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
              'message' => 'Zkontroluj své přihlašovací údaje.'
            ]);
        }

        return redirect()->home();
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->home();
    }
}
