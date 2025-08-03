<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class SSOController extends Controller
{
    public function login(Request $request)
    {
        $userId = $request->input('user_id');
        $sessionId = $request->input('session_id');

        $user = User::find($userId);
        if ($user) {
            Auth::login($user);
            Session::setId($sessionId);
            Session::save();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 400);
    }

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