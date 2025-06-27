@props(['project'])

<div x-data="{ open: false }" class="relative">

    <button x-on:click="open = !open"
        class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
        &#8942;
    </button>

    <div x-show="open" x-transition x-on:click.away="open = false"
        class="absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800
                border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-10">

        <button
            x-on:click="$dispatch('open-modal', 'task-create-{{ $project->id }}'); open = false"
            class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
            add new task
        </button>

        <button
            x-on:click="$dispatch('open-modal', 'edit-project-{{ $project->id }}'); open = false"
            class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
            edit
        </button>

        <button
            x-on:click="$dispatch('open-modal', 'delete-project-{{ $project->id }}'); open = false"
            class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
            delete
        </button>
    </div>

    <x-modal name="task-create-{{ $project->id }}" :show="false" focusable>
        <form method="POST" action="{{ route('tasks.store') }}" class="pb-6 pt-3 px-6 space-y-3">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}" />

            <h2>add new task to <strong>{{ $project->name }}</strong></h2>

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

            <h2>edit project name</h2>

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
            <h2>Delete Project</h2>
            <p>
                Are you sure, you want to delete <strong>{{ $project->name }}</strong>? All the data will be deleted.
            </p>
            <div class="flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-danger-button class="ml-2">Delete</x-danger-button>
            </div>
        </form>
    </x-modal>
</div>