<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Create a new instance of the controller
     * 
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Revoke the user's active token
     * 
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $request->user()->token()->delete();        
    }
}
