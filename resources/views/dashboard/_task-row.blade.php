@props(['task'])

<li class="ml-2 flex items-center justify-between gap-4">
    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
        @csrf @method('PATCH')
        <input type="checkbox"
               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-indigo-600"
               onchange="this.form.submit()"
               {{ $task->is_done ? 'checked' : '' }} />
    </form>

    <span class="flex-1 text-sm {{ $task->is_done ? 'line-through text-gray-500' : '' }} text-sm font-semibold text-gray-600 dark:text-gray-300">
        {{ $task->name }}
    </span>

    @include('dashboard._task-menu', ['task' => $task])
</li>