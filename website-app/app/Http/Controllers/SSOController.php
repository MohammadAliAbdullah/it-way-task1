<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class SSOController extends Controller
{
    public function logout(Request $request)
    {
        Session::setId($request->input('session_id'));
        Session::start();
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
        return response()->json(['status' => 'success']);
    }
}