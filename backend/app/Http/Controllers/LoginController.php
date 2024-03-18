<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'logged in'], 201);
        }

        throw ValidationException::withMessages([
            'credentials' => ['message' => 'The credentials don\'t match our records'],

        ]);
    }
}
