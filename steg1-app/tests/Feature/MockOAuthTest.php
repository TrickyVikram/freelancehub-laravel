<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserInfo;
use App\Services\MockOAuthService;

class MockOAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_mock_oauth_page()
    {
        $response = $this->get(route('mock-oauth.page'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.mock-oauth');
        $response->assertSee('Mock OAuth Testing');
    }

    public function test_can_login_with_mock_google_new_user()
    {
        $response = $this->get(route('mock-oauth.redirect', [
            'provider' => 'google',
            'variant' => 'default',
        ]));

        // Should redirect to callback
        $response->assertRedirect(route('mock-oauth.callback', 'google'));

        // Follow the callback
        $callbackResponse = $this->get(route('mock-oauth.callback', 'google'));

        // Should be logged in and redirected to jobs
        $callbackResponse->assertRedirect(route('jobs.index'));

        // Verify user was created
        $this->assertDatabaseHas('users', [
            'email' => 'john.google@example.com',
            'provider' => 'google',
        ]);

        // Verify user info was created
        $user = User::where('email', 'john.google@example.com')->first();
        $this->assertTrue($user->userInfo()->exists());
    }

    public function test_can_login_with_mock_github_new_user()
    {
        $response = $this->get(route('mock-oauth.redirect', [
            'provider' => 'github',
            'variant' => 'default',
        ]));

        $response->assertRedirect(route('mock-oauth.callback', 'github'));

        $callbackResponse = $this->get(route('mock-oauth.callback', 'github'));

        $callbackResponse->assertRedirect(route('jobs.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'jane.github@example.com',
            'provider' => 'github',
        ]);
    }

    public function test_can_login_with_mock_google_existing_user()
    {
        // Create existing user first
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        UserInfo::create(['user_id' => $user->id]);

        $response = $this->get(route('mock-oauth.redirect', [
            'provider' => 'google',
            'variant' => 'existing',
        ]));

        $response->assertRedirect(route('mock-oauth.callback', 'google'));

        $callbackResponse = $this->get(route('mock-oauth.callback', 'google'));

        $callbackResponse->assertRedirect(route('jobs.index'));

        // Verify same user was used
        $updatedUser = User::where('email', 'test@example.com')->first();
        $this->assertEquals('google', $updatedUser->provider);
        $this->assertEquals('google_existing', $updatedUser->provider_id);
    }

    public function test_can_login_with_mock_github_existing_user()
    {
        // Create existing user first
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        UserInfo::create(['user_id' => $user->id]);

        $response = $this->get(route('mock-oauth.redirect', [
            'provider' => 'github',
            'variant' => 'existing',
        ]));

        $response->assertRedirect(route('mock-oauth.callback', 'github'));

        $callbackResponse = $this->get(route('mock-oauth.callback', 'github'));

        $callbackResponse->assertRedirect(route('jobs.index'));

        $updatedUser = User::where('email', 'test@example.com')->first();
        $this->assertEquals('github', $updatedUser->provider);
    }

    public function test_rejects_invalid_provider()
    {
        $response = $this->get(route('mock-oauth.redirect', [
            'provider' => 'invalid',
        ]));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_mock_oauth_service_creates_correct_user_data()
    {
        $googleData = MockOAuthService::getMockUserData('google', 'default');

        $this->assertEquals('John Google', $googleData['name']);
        $this->assertEquals('john.google@example.com', $googleData['email']);
        $this->assertStringStartsWith('google_', $googleData['id']);

        $githubData = MockOAuthService::getMockUserData('github', 'default');

        $this->assertEquals('Jane GitHub', $githubData['name']);
        $this->assertEquals('jane.github@example.com', $githubData['email']);
        $this->assertStringStartsWith('github_', $githubData['id']);
    }

    public function test_user_is_authenticated_after_mock_oauth()
    {
        $this->get(route('mock-oauth.redirect', [
            'provider' => 'google',
            'variant' => 'default',
        ]));

        $this->get(route('mock-oauth.callback', 'google'));

        $this->assertAuthenticatedAs(
            User::where('email', 'john.google@example.com')->first()
        );
    }

    public function test_mock_oauth_creates_user_info_with_avatar()
    {
        $this->get(route('mock-oauth.redirect', [
            'provider' => 'google',
            'variant' => 'default',
        ]));

        $this->get(route('mock-oauth.callback', 'google'));

        $user = User::where('email', 'john.google@example.com')->first();
        $userInfo = $user->userInfo;

        $this->assertNotNull($userInfo);
        $this->assertNotNull($userInfo->avatar_url);
        $this->assertStringContainsString('google', strtolower($userInfo->avatar_url));
    }
}
