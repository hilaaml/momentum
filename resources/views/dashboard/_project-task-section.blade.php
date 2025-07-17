<x-content-card>
    @forelse ($projects as $project)
    @include('dashboard._project-row', ['project' => $project])
    <ul class="mt-2 pl-9 space-y-2">
        @foreach ($project->tasks as $task)
        @include('dashboard._task-row', ['task' => $task])
        @endforeach
    </ul>
    @empty
    <p class="py-4 text-center text-gray-500 dark:text-gray-300">You haven't created any projects.</p>
    @endforelse
</x-content-card>

<x-content-card>
    <div class="flex justify-center space-x-3">
        <x-secondary-button x-data x-on:click="$dispatch('open-modal', 'create-project')">
            + Project
        </x-secondary-button>

        <a href="{{ route('challenges.index') }}">
            <x-secondary-button>Challenges</x-secondary-button>
        </a>
    </div>

    <x-modal name="create-project" focusable>
        <form method="POST" action="{{ route('projects.store') }}" class="pb-6 pt-3 px-6 space-y-3">
            @csrf
            <h2 class="mb-2 pb-2 border-b text-sm font-semibold text-gray-600 dark:text-gray-300">Add new project </h2>
            <div>
                <x-text-input id="name" name="name" required autofocus class="mt-1 block w-full" placeholder="project name" />
                <x-input-error for="name" class="mt-2" />
            </div>
            <div class="flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button class="ml-2">Save</x-primary-button>
            </div>
        </form>
    </x-modal>
</x-content-card>