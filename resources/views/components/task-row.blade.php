@props(['task'])

<li class="ml-2 flex items-center justify-between gap-4">
    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
        @csrf @method('PATCH')
        <input type="checkbox"
               onchange="this.form.submit()"
               {{ $task->is_done ? 'checked' : '' }} />
    </form>

    <span class="flex-1 text-sm {{ $task->is_done ? 'line-through text-gray-500' : '' }}">
        {{ $task->name }}
    </span>

    <x-task-menu :task="$task" />
</li>
