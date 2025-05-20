<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\Role;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

       public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                Role::Admin => redirect()->route('admin.dashboard'),
                Role::Manager => redirect()->route('manager.dashboard'),
                Role::Agency => redirect()->route('agency.dashboard'),
                Role::User => redirect()->route('local.home'),
                default => redirect('/home'),
            };
        }

        return back()->withErrors([
            'email' => 'Email หรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
