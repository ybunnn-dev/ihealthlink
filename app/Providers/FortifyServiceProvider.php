<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\ProjectCrypt;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Config;


class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        // Fortify default setup
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        
        
        Config::set('auth.passwords.users.provider', 'users_encrypted');

        // Rate limiters
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('reset', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('auth-web', function ($request) {
            return Limit::perMinute(100)->by($request->user()->id);
        });

        RateLimiter::for('heavy-req', function ($request) {
            return Limit::perMinute(100)->by($request->user()->id);
        });

        RateLimiter::for('sync', function ($request) {
            return Limit::perMinute(500)->by($request->user()->id);
        });

        // Login response customization
        $this->app->singleton(LoginResponse::class, function (Container $container) {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = $request->user();
                    
                    // Midwife or BHW redirect
                    if (in_array($user->role_id, [2, 4])) {
                        $personnel = $user->personnel;
                        
                        if (!$personnel || !$personnel->brgy_id) {
                            \Log::info('No barangay assigned to your account.');
                            return redirect()->route('dashboard')
                                ->with('error', 'No barangay assigned to your account.');
                        }

                        $barangay = $personnel->barangay;
                        
                        if (!$barangay) {
                            return redirect()->route('home')
                                ->with('error', 'Barangay not found.');
                        }

                        return redirect()->route('midwife.dashboard', [
                            'barangay' => $barangay->name
                        ]);
                    }

                    // Other roles
                    return match ($user->role_id) {
                        1 => redirect()->intended('/mho/dashboard'),
                    };
                }
            };
        });
    }
}
