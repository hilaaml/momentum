@props(['project'])

<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button class="p-1 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            &#8942;
        </button>
    </x-slot>

    <x-slot name="content">
        <x-dropdown-link href="#" x-on:click.prevent="$dispatch('open-modal', 'task-create-{{ $project->id }}')">
            add new task
        </x-dropdown-link>

        <x-dropdown-link href="#" x-on:click.prevent="$dispatch('open-modal', 'edit-project-{{ $project->id }}')">
            edit
        </x-dropdown-link>

        <x-dropdown-link href="#" x-on:click.prevent="$dispatch('open-modal', 'delete-project-{{ $project->id }}')">
            <span class="text-red-600 dark:text-red-500">delete</span>
        </x-dropdown-link>
    </x-slot>
</x-dropdown>

<x-modal name="task-create-{{ $project->id }}" :show="false" focusable>
    <form method="POST" action="{{ route('tasks.store') }}" class="pb-6 pt-3 px-6 space-y-3">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}" />

        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">add new task to <strong>{{ $project->name }}</strong></h2>

        <div>
            <x-text-input id="task-name-{{ $project->id }}" name="name"
                class="mt-1 block w-full" required placeholder="task name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">cancel</x-secondary-button>
            <x-primary-button class="ml-2">add</x-primary-button>
        </div>
    </form>
</x-modal>

<x-modal name="edit-project-{{ $project->id }}" :show="false" focusable>
    <form method="POST" action="{{ route('projects.update', $project) }}" class="pb-6 pt-3 px-6 space-y-3">
        @csrf @method('PATCH')

        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">edit project name</h2>

        <div>
            <x-text-input id="project-name-{{ $project->id }}" name="name"
                value="{{ $project->name }}" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
            <x-primary-button class="ml-2">Save</x-primary-button>
        </div>
    </form>
</x-modal>

<x-modal name="delete-project-{{ $project->id }}" :show="false" focusable>
    <form method="POST" action="{{ route('projects.destroy', $project) }}" class="pb-6 pt-3 px-6 space-y-3">
        @csrf @method('DELETE')
        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">delete project</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300">Are you sure, you want to delete <strong>{{ $project->name }}</strong>? All the data will be deleted.</p>
        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
            <x-danger-button class="ml-2">Delete</x-danger-button>
        </div>
    </form>
</x-modal>