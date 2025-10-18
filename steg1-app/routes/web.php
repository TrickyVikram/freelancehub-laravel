<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\MockOAuthController;
use Illuminate\Support\Facades\Route;

// Redirect root to jobs index
Route::get('/', function () {
    return redirect()->route('jobs.index');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/quick-login', [AuthController::class, 'quickLogin'])->name('quick-login');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

// OAuth routes
Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirectToProvider'])->name('oauth.redirect');
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('oauth.callback');

// Password reset routes
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.store');

// Job routes
Route::resource('jobs', JobController::class);
Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('jobs.my-jobs');

// Proposal routes (public for testing)
Route::get('/proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');

// Mock OAuth routes (for testing without real credentials)
if (app()->environment(['testing', 'local'])) {
    Route::get('/auth/mock', [MockOAuthController::class, 'showMockPage'])->name('mock-oauth.page');
    Route::get('/auth/mock/{provider}/redirect', [MockOAuthController::class, 'mockRedirect'])->name('mock-oauth.redirect');
    Route::get('/auth/mock/{provider}/callback', [MockOAuthController::class, 'mockCallback'])->name('mock-oauth.callback');
}
