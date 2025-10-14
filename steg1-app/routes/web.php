<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProposalController;
use Illuminate\Support\Facades\Route;

// Redirect root to jobs index
Route::get('/', function () {
    return redirect()->route('jobs.index');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login', [AuthController::class, 'quickLogin'])->name('quick-login');

// Job routes
Route::resource('jobs', JobController::class);
Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('jobs.my-jobs');

// Proposal routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
    Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');
});
