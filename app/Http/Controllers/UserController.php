<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create() {
        return view('users.create');
    }

    public function store() {
        $formFields = request()->validate([
            'username' => ['required', 'unique:users,username', 'min:5'],
            'password' => ['required', 'confirmed', 'min:6'],
            'first_name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email']
        ]);

        $formFields['password'] = bcrypt($formFields['password']);
        $formFields['status'] = 0;
        $formFields['role'] = 3;

        $user = User::create($formFields);

        auth()->login($user);

        return redirect()->route('blogs')->with('message', 'Success! User created and logged in.');
    }

    public function login() {
        return view('users.login');
    }

    public function authenticate() {
        $formFields = request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(request()->attempt($formFields)) {
            request()->session()->regenerate();

            return redirect()->route('blogs')->with('message', 'User logged in.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    public function logout() {
        request()->session()->invalidate();

        return redirect()->route('blogs')->with('message', 'User logged out.');
    }
}
