<x-app-layout>
    @push('scripts')
    <script>
        window.heatmapData = @json($dailyData ?? []);
        window.heatmapStart = "{{ $from ?? now()->toDateString() }}";

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.initReportCharts === 'function') {
                window.initReportCharts(
                    @json($byDay),
                    @json($byHour),
                    @json($projectLabels),
                    @json($projectValues)
                );
            }
        });
    </script>
    @endpush

    <div class="max-w-screen-xl mx-auto space-y-6 text-center">

        <x-content-card centerXY>
            <form method="GET" action="{{ route('reports') }}" class="flex flex-wrap items-end gap-4">
                @foreach (['from' => 'From', 'to' => 'To'] as $field => $label)
                <div class="flex flex-col">
                    <label class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}:</label>
                    <input type="date" name="{{ $field }}"
                        value="{{ request($field) ?? now()->{ $field === 'from' ? 'startOfMonth' : 'now' }()->toDateString() }}"
                        class="rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-1 py-1 text-xs">
                </div>
                @endforeach
                <x-primary-button class="p-2">Show</x-primary-button>
            </form>
        </x-content-card>

        <x-content-card class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center place-items-center">
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            {{-- Most Active Day --}}
            <x-content-card centerXY>
                <div class="space-y-4 w-full">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Most Active Day: <strong>{{ ucfirst($mostActiveDay) }}</strong></p>
                    <canvas id="activeDaysChart" class="w-full h-[200px]"></canvas>
                </div>
            </x-content-card>

            <x-content-card centerXY>
                <div class="space-y-4 w-full">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Activity Heatmap</p>

                    <div class="w-full overflow-x-auto text-center">
                        <div id="heatmap" class="mx-auto min-w-[300px] max-w-full inline-block"></div>
                    </div>
                </div>
            </x-content-card>


            <x-content-card centerXY>
                <div class="space-y-4 w-full">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Most Active Hour:
                        <strong>{{ $mostActiveHour }}:00–{{ (int)$mostActiveHour + 1 }}:00</strong>
                    </p>
                    <canvas id="hourlyChart" class="w-full h-[200px]"></canvas>
                </div>
            </x-content-card>

            <x-content-card centerXY>
                <div class="space-y-4 w-full text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Top Time-Consuming Project:
                        <strong>{{ $topProject?->name ?? '—' }}</strong>
                        ({{ \Carbon\CarbonInterval::seconds($topProjectSeconds)->cascade()->forHumans() }})
                    </p>
                    <div class="flex justify-center items-center h-[250px]">
                        <canvas id="projectPieChart"></canvas>
                    </div>
                </div>
            </x-content-card>
        </div>

        <x-content-card>
            <p class="text-sm text-gray-600 dark:text-gray-300 pb-3">Activity Timeline</p>
            <x-timeline-table :logs="$allLogs" class="h-[500px] overflow-y-auto" />
        </x-content-card>

    </div>
</x-app-layout>