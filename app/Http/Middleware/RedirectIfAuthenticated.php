<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                // Check if user is active
                if ($user->status !== 'active') {
                    Auth::logout();
                    return redirect()->route('login')
                        ->with('error', 'Your account has been deactivated.');
                }
                
                // Redirect based on role
                return $this->redirectBasedOnRole($user);
            }
        }

        return $next($request);
    }
    
    private function redirectBasedOnRole($user)
    {
        switch ($user->role_id) {
            case 1: // Admin/MHO
                return redirect()->route('mho.dashboard');
                
            case 2: // BHW
            case 4: // Web BHW
                // Get personnel record (bhw, bhwWeb, or midwife)
                $personnel = $user->bhw ?? $user->bhwWeb ?? $user->midwife;
                
                if (!$personnel || !$personnel->brgy_id) {
                    // No personnel record or barangay - redirect to generic dashboard or error
                    \Log::info('No barangay assigned to your account.');
                    return redirect()->route('dashboard')
                        ->with('error', 'No barangay assigned to your account.');
                }
                
               
                $barangay = $personnel->barangay; // Assumes Personnel has barangay() relationship
                
                if (!$barangay) {
                    return redirect()->route('home')
                        ->with('error', 'Barangay not found.');
                }
                
                // Redirect with barangay name or slug
                return redirect()->route('midwife.dashboard', [
                    'barangay' => $barangay->name // Or $barangay->slug if you have one
                ]);
                
            default:
                return redirect()->route('home');
        }
    }
}