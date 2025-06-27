<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Journal;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use App\Policies\JournalPolicy;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

    protected $policies = [
        Journal::class => JournalPolicy::class,
        Project::class => ProjectPolicy::class,
        Task::class => TaskPolicy::class,

    ];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
