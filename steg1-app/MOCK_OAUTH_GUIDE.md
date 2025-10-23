# Mock OAuth Testing Guide

## Overview

Mock OAuth allows you to test OAuth login flows (Google & GitHub) **without needing real API credentials**. This is perfect for local development and testing.

## What Was Created

### 1. **MockOAuthService** (`app/Services/MockOAuthService.php`)
- Generates mock user data for Google and GitHub
- Handles user creation/authentication
- Supports multiple user variants (default, existing)

### 2. **MockOAuthController** (`app/Http/Controllers/MockOAuthController.php`)
- Routes OAuth redirect/callback requests
- Authenticates users with mock data
- Stores provider information in database

### 3. **Mock OAuth Routes**
Routes are available in `local` and `testing` environments only:
- `GET /auth/mock` — Mock OAuth test page
- `GET /auth/mock/{provider}/redirect` — Simulate OAuth redirect
- `GET /auth/mock/{provider}/callback` — Simulate OAuth callback

### 4. **Mock OAuth View** (`resources/views/auth/mock-oauth.blade.php`)
- Clean Bootstrap UI for testing
- Easy selection of providers and user variants
- Available in local/testing environments

### 5. **9 Feature Tests** (`tests/Feature/MockOAuthTest.php`)
- ✅ View mock OAuth page
- ✅ Login with Google (new user)
- ✅ Login with GitHub (new user)
- ✅ Login with Google (existing user)
- ✅ Login with GitHub (existing user)
- ✅ Reject invalid providers
- ✅ Service creates correct mock data
- ✅ User authenticated after OAuth
- ✅ Avatar URL created correctly

## How to Use

### In Browser (Local Development)

1. Start your Laravel server:
   ```bash
   php artisan serve
   ```

2. Go to login page:
   ```
   http://localhost:8000/login
   ```

3. Scroll down to "Testing Mode" section and click **Mock OAuth Test**

4. Choose a provider and variant:
   - **Google New User** — Creates user: john.google@example.com
   - **Google Existing User** — Uses test@example.com
   - **GitHub New User** — Creates user: jane.github@example.com
   - **GitHub Existing User** — Uses test@example.com

5. You're logged in! 🎉

### In Feature Tests

Use the mock OAuth routes directly:

```php
// Test Google login with new user
$response = $this->get(route('mock-oauth.redirect', [
    'provider' => 'google',
    'variant' => 'default',
]));

$response->assertRedirect(route('mock-oauth.callback', 'google'));

$this->get(route('mock-oauth.callback', 'google'));

$this->assertDatabaseHas('users', [
    'email' => 'john.google@example.com',
    'provider' => 'google',
]);
```

### Using MockOAuthService Directly

```php
use App\Services\MockOAuthService;

// Get mock user data
$googleData = MockOAuthService::getMockUserData('google', 'default');
// Returns: ['id' => 'google_...', 'name' => 'John Google', 'email' => 'john.google@example.com', 'avatar' => '...']

// Authenticate user
$user = MockOAuthService::authenticateUser('google', $googleData);
// User is created or found, and returned
```

## Mock User Variants

### Google
- **default** — john.google@example.com (new user)
- **existing** — test@example.com (existing user)

### GitHub
- **default** — jane.github@example.com (new user)
- **existing** — test@example.com (existing user)

## Environment Configuration

Mock OAuth routes are only available in:
- `APP_ENV=local`
- `APP_ENV=testing`

To check/set your environment:
```bash
# Check current environment
grep APP_ENV .env

# For development, set:
APP_ENV=local

# Tests automatically use:
APP_ENV=testing
```

## Test Results

All tests pass ✅:
```
PHPUnit 11.5.42

9 MockOAuth Tests ............... PASS (40 assertions)
4 Other Tests ................... PASS (8 assertions)
─────────────────────────────────────────
13 Total Tests .................. PASS (48 assertions)
OK
```

## Real OAuth Setup (When Ready)

When you're ready to use real Google/GitHub OAuth:

1. Get credentials from:
   - Google: https://console.developers.google.com
   - GitHub: https://github.com/settings/developers

2. Add to `.env`:
   ```
   GOOGLE_CLIENT_ID=your_id
   GOOGLE_CLIENT_SECRET=your_secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

   GITHUB_CLIENT_ID=your_id
   GITHUB_CLIENT_SECRET=your_secret
   GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback
   ```

3. The real OAuth routes (`/auth/{provider}/redirect`) will automatically take over when credentials are configured

4. During testing, mock routes will still work for unit/feature tests

## File Structure

```
app/
  Services/
    MockOAuthService.php          ← Mock user data & authentication
  Http/Controllers/
    MockOAuthController.php       ← Mock OAuth routes
routes/
  web.php                         ← Mock OAuth routes (local/testing)
resources/views/auth/
  mock-oauth.blade.php            ← Testing UI
tests/Feature/
  MockOAuthTest.php               ← 9 feature tests
```

## Key Features

✅ **Zero Configuration** — Works out of the box, no real credentials needed
✅ **Multiple Variants** — Test new user and existing user scenarios
✅ **Full Coverage** — 9 comprehensive tests included
✅ **Database Integration** — Users stored with provider details
✅ **Avatar Support** — Mock user data includes avatar URLs
✅ **Environment-Safe** — Only available in local/testing
✅ **Easy to Extend** — Add more user variants or providers easily

## Troubleshooting

**Q: Mock OAuth page not showing?**
- Make sure `APP_ENV=local` or `APP_ENV=testing`
- Check that you're on the login page

**Q: User not being created?**
- Check database migrations ran: `php artisan migrate:status`
- Verify `users` table has `provider` and `provider_id` columns

**Q: Tests failing?**
- Run `php artisan migrate:refresh` to reset test database
- Check `phpunit.xml` environment is set to testing

---

**Happy testing! 🚀**
