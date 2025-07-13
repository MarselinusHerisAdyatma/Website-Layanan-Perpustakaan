<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return $this->redirectByRole(auth()->user()->role->name);
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectByRole(auth()->user()->role->name);
        }

        return redirect('/login')->with('error', 'Username atau Password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function redirectByRole($role)
    {
        return match ($role) {
            'Super Admin' => redirect('/dashboard/superadmin'),
            'Admin'       => redirect('/dashboard/admin'),
            default       => redirect('/login')->with('error', 'Role tidak dikenali.'),
        };
    }


}
