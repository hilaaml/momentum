<x-content-card class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center place-items-center ">
    @foreach ([
        'Total Time' => \Carbon\CarbonInterval::seconds($totalSeconds)->cascade()->format('%h hours %i minutes %s seconds'),
        'Average Per Day' => \Carbon\CarbonInterval::seconds($averagePerDay)->cascade()->format('%h hours %i minutes %s seconds'),
        'Completed Tasks' => $completedTasksCount,
        'Tracked Projects' => $trackedProjectCount,
    ] as $label => $value)
    <div>
        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $label }}</p>
        <strong class="text-lg text-indigo-600 dark:text-indigo-400">{{ $value }}</strong>
    </div>
    @endforeach
</x-content-card>
