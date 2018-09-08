<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
{
  public function create()
  {
    return view('registration.create');
  }

  public function store(RegistrationRequest $request)
  {
    $user = User::create([
      'name' => request('name'),
      'email' => request('email'),
      'password' => bcrypt(request('password'))
    ]);

    auth()->login($user);

    session()->flash('message', 'Děkujeme za Vaši registraci.');

    return redirect()->home();
  }
}
