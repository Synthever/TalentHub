<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Mahasiswa\LeaderboardController;
use App\Http\Controllers\Mahasiswa\PortfolioController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Mahasiswa\RewardController;
use App\Http\Controllers\Mahasiswa\SkillController;
use Illuminate\Support\Facades\Route;

// Landing redirect
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('mahasiswa.dashboard'),
        };
    }

    return redirect()->route('login');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Students
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    });

    // Mahasiswa routes
    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Mahasiswa\DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

        // Skills
        Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
        Route::get('/skills/tambah', [SkillController::class, 'create'])->name('skills.create');
        Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
        Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

        // Portfolios
        Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');
        Route::get('/portfolios/tambah', [PortfolioController::class, 'create'])->name('portfolios.create');
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');
        Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

        // Leaderboard
        Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

        // Rewards
        Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
        Route::post('/rewards/{reward}/claim', [RewardController::class, 'claim'])->name('rewards.claim');
    });
});
