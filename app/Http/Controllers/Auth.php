<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;

class Auth extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!AuthFacade::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'E-mail ou senha inválidos.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = AuthFacade::user();

        return redirect()->intended(route('user.profile', ['id' => $user->id]));
    }

    public function destroy(Request $request): RedirectResponse
    {
        AuthFacade::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
