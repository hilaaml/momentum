<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    DashboardController,
    ReportController,
    TimeLogController,
    SettingController,
    ProjectController,
    TaskController,
    JournalController,
    ProfileController,
    Auth\SocialiteController,
    RewardController,
    ChallengeController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        // : redirect()->route('login');
        : view('welcome');
});

// Socialite
Route::prefix('auth/{provider}')->name('socialite.')->group(function () {
    Route::get('/', [SocialiteController::class, 'redirectToProvider'])->name('redirect');
    Route::get('/callback', [SocialiteController::class, 'handleProviderCallback'])->name('callback');
});

Route::middleware('auth')->group(function () {
    // Core pages
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/timeline', [TimeLogController::class, 'index'])->name('timeline');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/streak-config', [DashboardController::class, 'updateStreakConfig'])->name('dashboard.streak-config');

    // Projects
    Route::resource('projects', ProjectController::class)->except(['index', 'show']);
    Route::controller(TimeLogController::class)->prefix('projects/{project}')->name('projects.')->group(function () {
        Route::post('/start', 'start')->name('start');
        Route::post('/stop', 'stop')->name('stop');
    });

    // Tasks
    Route::resource('tasks', TaskController::class)->only(['store', 'update', 'destroy']);
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    // Journal
    Route::resource('journal', JournalController::class)->names('journal');

    // Rewards
    Route::resource('rewards', RewardController::class)
        ->only(['index', 'store', 'destroy'])
        ->middleware('auth');
    Route::post('/rewards/{reward}/redeem', [RewardController::class, 'redeem'])->name('rewards.redeem');

    // Challenge
    // Challenge
    Route::get('/challenges/available', [ChallengeController::class, 'available'])->name('challenges.available');
    Route::get('/challenges/created', [ChallengeController::class, 'created'])->name('challenges.created');
    Route::get('/challenges/{challenge}/participants', [ChallengeController::class, 'participants'])
        ->name('challenges.participants');

    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::post('/challenges/{id}/join', [ChallengeController::class, 'join'])->name('challenge.join');
    Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::post('/challenges/{challenge}/upload-proof', [ChallengeController::class, 'uploadProof'])->name('challenges.uploadProof');
    Route::post('/challenges/{challenge}/leave', [ChallengeController::class, 'leave'])->name('challenge.leave');
    Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');
    Route::delete('/challenges/{id}', [ChallengeController::class, 'destroy'])->name('challenges.destroy');
    Route::delete('/challenges/{challenge}/participants/{user}', [ChallengeController::class, 'removeParticipant'])->name('challenge.removeParticipant');

    // Settings
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    Route::middleware(['auth'])->get('/settings', function () {
        return view('settings', [
            'user' => auth()->user(),
        ]);
    })->name('settings');
});

require __DIR__ . '/auth.php';
