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
