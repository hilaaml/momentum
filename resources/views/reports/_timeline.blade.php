<x-content-card>
    <p class="text-sm text-gray-600 dark:text-gray-300 pb-3">Activity Timeline</p>
    <x-timeline-table :logs="$allLogs" class="h-[500px] overflow-y-auto" />
</x-content-card>