<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirebaseController extends Controller
{
    public function updateToken(Request $request)
    {
        $request->validate(['fcm_token' => 'required|string']);
        
        $user = Auth::user();
        $user->fcm_token = $request->fcm_token;
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Token updated']);
    }
}
