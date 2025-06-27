@props(['logs'])

<table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
    <thead class="bg-gray-200 dark:bg-gray-700">
        <tr>
            <th class="p-2">Proyek</th>
            <th class="p-2">Mulai</th>
            <th class="p-2">Selesai</th>
            <th class="p-2">Durasi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($logs as $log)
            <tr class="border-b border-gray-300 dark:border-gray-600">
                <td class="p-2">{{ $log->project->name ?? '-' }}</td>
                <td class="p-2">{{ $log->start_time->format('d M Y H:i') }}</td>
                <td class="p-2">
                    {{ $log->end_time ? $log->end_time->format('d M Y H:i') : '-' }}
                </td>
                <td class="p-2">
                    @if ($log->end_time)
                        {{ \Carbon\CarbonInterval::seconds($log->end_time->diffInSeconds($log->start_time))->cascade()->format('%H:%I:%S') }}
                    @else
                        <span class="text-red-500">Sedang Aktif</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data log.</td>
            </tr>
        @endforelse
    </tbody>
</table>
