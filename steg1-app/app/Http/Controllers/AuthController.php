<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('jobs.index'))->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // Create user info record
        UserInfo::create([
            'user_id' => $user->id,
        ]);

        Auth::login($user);

        return redirect()->route('jobs.index')->with('success', 'Account created successfully! Welcome!');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('jobs.index')->with('success', 'You have been logged out.');
    }

    /**
     * Quick login for testing (creates or logs in test user).
     */
    public function quickLogin()
    {
        // Find or create a test user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Ensure user info record exists
        if (!$user->userInfo) {
            UserInfo::create(['user_id' => $user->id]);
        }

        Auth::login($user);

        return redirect()->route('jobs.index')->with('success', 'You are now logged in as a test user!');
    }

    /**
     * Redirect to OAuth provider.
     */
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google', 'github'])) {
            return redirect()->route('login')->with('error', 'Invalid provider.');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle OAuth callback from provider.
     */
    public function handleProviderCallback($provider)
    {
        if (!in_array($provider, ['google', 'github'])) {
            return redirect()->route('login')->with('error', 'Invalid provider.');
        }

        try {
            $oauthUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to authenticate with ' . ucfirst($provider) . '.');
        }

        // Find or create user
        $user = User::where('provider', $provider)
                    ->where('provider_id', $oauthUser->getId())
                    ->first();

        if (!$user) {
            // Check if user with this email exists
            $existingUser = User::where('email', $oauthUser->getEmail())->first();

            if ($existingUser) {
                $user = $existingUser;
                // Update OAuth fields if not set
                if (!$user->provider) {
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $oauthUser->getId(),
                    ]);
                }
            } else {
                // Create new user
                $user = User::create([
                    'name' => $oauthUser->getName(),
                    'email' => $oauthUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $oauthUser->getId(),
                    'role' => 'user',
                    'password' => Hash::make(uniqid()),
                ]);

                // Create user info record with avatar
                UserInfo::create([
                    'user_id' => $user->id,
                    'avatar_url' => $oauthUser->getAvatar(),
                ]);
            }
        }

        Auth::login($user, remember: true);

        return redirect()->route('jobs.index')->with('success', 'Successfully logged in with ' . ucfirst($provider) . '!');
    }

    /**
     * Show the forgot password form.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
}