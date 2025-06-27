@props(['project'])

<div class="flex items-center justify-between gap-4 mt-2">

    <div class="flex gap-5 items-center">
        <x-project-toggle :project="$project" />

        <h3 class="text-base font-semibold truncate">{{ $project->name }}</h3>
    </div>

    <div class="flex items-center justify-end">
        <x-project-timer :seconds="$project->total_seconds" :active="$project->is_active" />

        <x-project-menu :project="$project" />
    </div>
</div>