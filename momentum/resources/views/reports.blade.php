<x-app-layout>
    {{-- --- PHP → JS bridge (must stay inside @push so layout can place it) --}}
    @push('scripts')
    <script>
        window.heatmapData = @json($dailyData ?? []);
        window.heatmapStart = "{{ $from ?? now()->toDateString() }}";
    </script>
    @endpush

    <x-header title="Reports" />

    <div
        class="grid gap-6 px-4 py-4 sm:px-8 lg:px-12
               grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

        <x-content-card class="col-span-full">
            <form method="GET"
                action="{{ route('reports') }}"
                class="flex flex-col sm:flex-row flex-wrap gap-4 sm:gap-6
                           justify-center items-end mx-auto max-w-4xl">

                <div class="w-full sm:w-auto">
                    <label class="block mb-1 text-sm text-gray-700 dark:text-gray-300">From:</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                        class="w-full sm:w-40 px-2 py-1 rounded border
                                   border-gray-300 dark:border-gray-600
                                   dark:bg-gray-700 dark:text-white">
                </div>

                <div class="w-full sm:w-auto">
                    <label class="block mb-1 text-sm text-gray-700 dark:text-gray-300">To:</label>
                    <input type="date" name="to" value="{{ request('to') }}"
                        class="w-full sm:w-40 px-2 py-1 rounded border
                                   border-gray-300 dark:border-gray-600
                                   dark:bg-gray-700 dark:text-white">
                </div>

                <x-primary-button class="w-full sm:w-auto">
                    Show
                </x-primary-button>
            </form>
        </x-content-card>

        <x-content-card>
            <p>Total waktu:
                <strong>{{ \Carbon\CarbonInterval::seconds($totalSeconds)->cascade()->format('%h jam %i menit %s detik') }}</strong>
            </p>
        </x-content-card>

        <x-content-card>
            <p>Rata-rata per hari:
                <strong>{{ \Carbon\CarbonInterval::seconds($averagePerDay)->cascade()->format('%h jam %i menit %s detik') }}</strong>
            </p>
        </x-content-card>

        <x-content-card>
            @if ($mostActiveDay && $mostActiveHour)
            <p>Hari paling aktif:
                <strong>{{ ucfirst($mostActiveDay) }}</strong>
            </p>
            <p>Jam paling aktif:
                <strong>{{ $mostActiveHour }}:00–{{ (int)$mostActiveHour + 1 }}:00</strong>
            </p>
            @else
            <p class="text-gray-500 dark:text-gray-400">
                Belum ada data aktivitas yang cukup.</p>
            @endif
        </x-content-card>

        <x-content-card class="col-span-full">
            <div class="overflow-x-auto max-w-full">
                <div id="heatmap" class="inline-block min-w-[640px]"></div>
            </div>
        </x-content-card>
    </div>
</x-app-layout>