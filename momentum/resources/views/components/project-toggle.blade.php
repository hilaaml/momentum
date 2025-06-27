@props(['project'])

<form method="POST" action="{{ $project->isActive ? route('projects.stop', $project) : route('projects.start', $project) }}">
    @csrf
    <button type="submit"
        class="p-2 rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition">
        @if ($project->isActive)
        <x-icon.stop class="text-red-500" />
        @else
        <x-icon.play class="text-green-500" />
        @endif
    </button>
</form>