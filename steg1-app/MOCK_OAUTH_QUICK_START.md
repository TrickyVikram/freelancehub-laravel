# Quick Start: Mock OAuth

## For Developers

### Run Local Server
```bash
php artisan serve
```

### Access Mock OAuth
```
http://localhost:8000/login
```
→ Scroll to "Testing Mode" section
→ Click "Mock OAuth Test"
→ Choose provider & user variant

### Test Users Available

| Provider | Email | Password | Use Case |
|----------|-------|----------|----------|
| Google (New) | john.google@example.com | N/A (OAuth) | New user signup |
| Google (Existing) | test@example.com | N/A (OAuth) | Linking to existing |
| GitHub (New) | jane.github@example.com | N/A (OAuth) | New user signup |
| GitHub (Existing) | test@example.com | N/A (OAuth) | Linking to existing |

---

## For Testing

### Run Mock OAuth Tests
```bash
vendor/bin/phpunit --filter MockOAuth
```

### Expected Result
```
MockOAuthTest ........... 9 / 9 (100%) PASS
```

---

## How It Works

1. Click a mock OAuth button
2. Get redirected to `/auth/mock/{provider}/callback`
3. `MockOAuthController` processes callback
4. `MockOAuthService` creates/finds user
5. User logged in automatically
6. Redirected to jobs index

**Zero real API calls needed!** ✨

---

## Code Examples

### Test Google Login
```php
$this->get(route('mock-oauth.redirect', ['provider' => 'google', 'variant' => 'default']));
$this->get(route('mock-oauth.callback', 'google'));
$this->assertAuthenticatedAs(User::where('email', 'john.google@example.com')->first());
```

### Get Mock Data
```php
$data = MockOAuthService::getMockUserData('github', 'default');
// $data['name'] = 'Jane GitHub'
// $data['email'] = 'jane.github@example.com'
```

---

## Environment Check

Mock OAuth only works in `local` or `testing` environments.

Check your `.env`:
```bash
APP_ENV=local
```

For production, use real OAuth with real credentials.
