<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Sync session with website-app
            $response = Http::post('http://localhost:8000/sso/login', [
                'user_id' => Auth::id(),
                'session_id' => $request->session()->getId(),
            ]);

            if ($response->successful()) {
                return redirect()->intended('/dashboard');
            }

            return back()->withErrors(['error' => 'Failed to sync with website-app.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Notify website-app to logout
        Http::post('http://localhost:8000/sso/logout', [
            'session_id' => $request->session()->getId(),
        ]);

        return redirect('/');
    }
}