@props(['task'])

<div x-data="{ open:false }" class="relative">
    <button x-on:click="open = !open"
        class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
        &#8942;
    </button>

    <div x-show="open" x-transition x-on:click.away="open = false"
        class="absolute right-0 mt-2 w-28 bg-white dark:bg-gray-800
                border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-10">
        <button
            x-on:click="$dispatch('open-modal', 'edit-task-{{ $task->id }}'); open = false"
            class="w-full px-3 py-2 text-left text-xs hover:bg-gray-100 dark:hover:bg-gray-700">
            Edit
        </button>
        <button
            x-on:click="$dispatch('open-modal', 'delete-task-{{ $task->id }}'); open = false"
            class="w-full px-3 py-2 text-left text-xs text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
            Delete
        </button>
    </div>


    <x-modal name="edit-task-{{ $task->id }}" :show="false" focusable>
        <form method="POST" action="{{ route('tasks.update', $task) }}" class="pb-6 pt-3 px-6 space-y-3">
            @csrf @method('PATCH')

            <h2>Edit Task</h2>

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

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete task</h2>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete this task (<strong>{{ $task->name }}</strong>) ?
            </p>

            <div class="flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-danger-button class="ml-2">Delete</x-danger-button>
            </div>
        </form>
    </x-modal>
</div>