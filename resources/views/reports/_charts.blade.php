<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
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
