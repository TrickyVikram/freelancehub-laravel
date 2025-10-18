<?php

namespace App\Http\Controllers;

use App\Services\MockOAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MockOAuthController extends Controller
{
    /**
     * Show mock OAuth selection page (for testing)
     */
    public function showMockPage()
    {
        return view('auth.mock-oauth', [
            'providers' => ['google', 'github'],
        ]);
    }

    /**
     * Handle mock OAuth redirect
     */
    public function mockRedirect(Request $request, string $provider)
    {
        if (!MockOAuthService::isValidProvider($provider)) {
            return redirect()->route('login')->with('error', 'Invalid provider.');
        }

        // Store provider and variant in session for callback
        session([
            'mock_oauth_provider' => $provider,
            'mock_oauth_variant' => $request->query('variant', 'default'),
        ]);

        return redirect()->route('mock-oauth.callback', $provider);
    }

    /**
     * Handle mock OAuth callback
     */
    public function mockCallback(Request $request, string $provider)
    {
        if (!MockOAuthService::isValidProvider($provider)) {
            return redirect()->route('login')->with('error', 'Invalid provider.');
        }

        $variant = session('mock_oauth_variant', 'default');

        try {
            $oauthData = MockOAuthService::getMockUserData($provider, $variant);
            $user = MockOAuthService::authenticateUser($provider, $oauthData);

            Auth::login($user, remember: true);

            session()->forget(['mock_oauth_provider', 'mock_oauth_variant']);

            return redirect()->route('jobs.index')->with('success', 'Successfully logged in with ' . ucfirst($provider) . ' (Mock)!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Mock OAuth authentication failed: ' . $e->getMessage());
        }
    }
}
