<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            
            return redirect()->intended('/book');
        }
        
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }
}