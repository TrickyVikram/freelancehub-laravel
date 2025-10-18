<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MockOAuthService
{
    /**
     * Supported providers for mock OAuth
     */
    protected static array $providers = ['google', 'github'];

    /**
     * Get mock user data for a provider
     */
    public static function getMockUserData(string $provider, string $variant = 'default'): array
    {
        return match ($provider) {
            'google' => self::getMockGoogleData($variant),
            'github' => self::getMockGithubData($variant),
            default => [],
        };
    }

    /**
     * Get mock Google user data
     */
    protected static function getMockGoogleData(string $variant = 'default'): array
    {
        $variants = [
            'default' => [
                'id' => 'google_' . uniqid(),
                'name' => 'John Google',
                'email' => 'john.google@example.com',
                'avatar' => 'https://lh3.googleusercontent.com/a/default-user',
            ],
            'existing' => [
                'id' => 'google_existing',
                'name' => 'Test User',
                'email' => 'test@example.com',
                'avatar' => 'https://lh3.googleusercontent.com/a/existing-user',
            ],
        ];

        return $variants[$variant] ?? $variants['default'];
    }

    /**
     * Get mock GitHub user data
     */
    protected static function getMockGithubData(string $variant = 'default'): array
    {
        $variants = [
            'default' => [
                'id' => 'github_' . uniqid(),
                'name' => 'Jane GitHub',
                'email' => 'jane.github@example.com',
                'avatar' => 'https://avatars.githubusercontent.com/u/default',
            ],
            'existing' => [
                'id' => 'github_existing',
                'name' => 'Test User',
                'email' => 'test@example.com',
                'avatar' => 'https://avatars.githubusercontent.com/u/existing',
            ],
        ];

        return $variants[$variant] ?? $variants['default'];
    }

    /**
     * Create or find user from mock OAuth data
     */
    public static function authenticateUser(string $provider, array $oauthData): User
    {
        // Find by provider ID
        $user = User::where('provider', $provider)
                    ->where('provider_id', (string) $oauthData['id'])
                    ->first();

        if ($user) {
            return $user;
        }

        // Find by email if exists
        $existingUser = User::where('email', $oauthData['email'])->first();

        if ($existingUser) {
            if (!$existingUser->provider) {
                $existingUser->update([
                    'provider' => $provider,
                    'provider_id' => (string) $oauthData['id'],
                ]);
            }
            return $existingUser;
        }

        // Create new user
        $user = User::create([
            'name' => $oauthData['name'],
            'email' => $oauthData['email'],
            'provider' => $provider,
            'provider_id' => (string) $oauthData['id'],
            'role' => 'user',
            'password' => Hash::make(uniqid()),
        ]);

        // Create user info with avatar
        UserInfo::create([
            'user_id' => $user->id,
            'avatar_url' => $oauthData['avatar'] ?? null,
        ]);

        return $user;
    }

    /**
     * Check if provider is valid
     */
    public static function isValidProvider(string $provider): bool
    {
        return in_array($provider, self::$providers);
    }
}
