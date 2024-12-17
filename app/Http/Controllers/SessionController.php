<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
class SessionController extends Controller
{
    public function refreshSession(Request $request)
    {
        // Refresh the session expiration time
        Session::put('last_activity', now());

        // Regenerate CSRF token
        $newToken = csrf_token();

        // Return the new CSRF token to the frontend
        return response()->json(['csrf_token' => $newToken]);
    }

    public function logout(Request $request)
    {
        // Log the user out and invalidate the session
        auth()->logout();
        Session::flush();

        return redirect('/login');
    }
}
