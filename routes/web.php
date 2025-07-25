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
        : redirect()->route('login');
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

    // Profile
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

require __DIR__.'/auth.php';
