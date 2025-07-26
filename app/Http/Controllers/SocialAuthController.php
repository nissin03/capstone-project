<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialiteUser = Socialite::driver('google')->stateless()->user();
            $email = $socialiteUser->getEmail();

            if (!str_ends_with($email, '@cvsu.edu.ph') && !str_ends_with($email, '@gmail.com')) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Please use your @cvsu.edu.ph or @gmail.com email address.',
                ]);
            }
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $socialiteUser->getName(),
                    'password' => Hash::make(uniqid()),
                    'password_set' => false,
                ]
            );

            if (!$user->hasAnyRole(['admin', 'dir', 'user'])) {
                $user->assignRole('user');
            }
            if (!$user->wasRecentlyCreated && $user->password_set) {
                Auth::login($user);
                return redirect()->intended('/');
            }
            Auth::login($user);

            if (!$user->password_set) {
                return Inertia::location(route('password.set'));
            }

            return redirect()->intended('/');
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'oauth' => 'Login failed, please try again.',
            ]);
        }
    }
}
