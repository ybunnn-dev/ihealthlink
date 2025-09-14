<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barangay;

class RedirectBarangayController extends Controller
{
    public function redirect(Request $request)
    {
        $user = $request->user();

        // Get the personnel record based on role
        if ($user->role_id === 2) {
            $personnel = $user->midwife;
        } elseif ($user->role_id === 4) {
            $personnel = $user->bhw;
        } else {
            // Default fallback for other roles
            \Log::info('vakla');
            return redirect()->intended('/');
        }

        // Make sure $personnel exists
        if (!$personnel) {
            
            return redirect()->intended('/');
        }

        // Get the barangay
        $barangay = Barangay::find($personnel->brgy_id);
        if (!$barangay) {
            return redirect()->intended('/');
        }

        // Build dynamic URLs based on role
        if ($user->role_id === 2) {
            return redirect()->intended("/midwife/{$barangay->name}/dashboard");
        }

        if ($user->role_id === 4) {
            return redirect()->intended("/bhw/{$barangay->name}/dashboard");
        }

        // Fallback (should not reach here)
        return redirect()->intended('/');
    }
}
