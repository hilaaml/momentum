@props(['task'])

<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
            <span class="text-gray-600 dark:text-gray-300">⋮</span>
        </button>
    </x-slot>

    <x-slot name="content">
        <x-dropdown-link href="#" x-on:click.prevent="$dispatch('open-modal', 'edit-task-{{ $task->id }}')">
            edit
        </x-dropdown-link>

        <x-dropdown-link href="#" x-on:click.prevent="$dispatch('open-modal', 'delete-task-{{ $task->id }}')">
            <span class="text-red-600 dark:text-red-500">delete</span>
        </x-dropdown-link>
    </x-slot>
</x-dropdown>

<x-modal name="edit-task-{{ $task->id }}" :show="false" focusable>
    <form method="POST" action="{{ route('tasks.update', $task) }}" class="pb-6 pt-3 px-6 space-y-3">
        @csrf @method('PATCH')

        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Edit Task</h2>

        <div>
            <x-text-input
                id="task-name-{{ $task->id }}" name="name"
                value="{{ $task->name }}"
                class="mt-1 block w-full"
                required
                placeholder="Task name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
            <x-primary-button class="ml-2">Save</x-primary-button>
        </div>
    </form>
</x-modal>

<x-modal name="delete-task-{{ $task->id }}" :show="false" focusable>
    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="pb-6 pt-3 px-6 space-y-3">
        @csrf @method('DELETE')

        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Delete task</h2>

        <p class="text-sm text-gray-600 dark:text-gray-400">
            Are you sure you want to delete this task (<strong>{{ $task->name }}</strong>) ?
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
            <x-danger-button class="ml-2">Delete</x-danger-button>
        </div>
    </form>
</x-modal>