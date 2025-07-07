<table class="w-full table-fixed text-center border-collapse mb-4 text-sm">
    <thead>
        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            @foreach (['Su','Mo','Tu','We','Th','Fr','Sa'] as $day)
            <th class="p-1">{{ $day }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($weeks as $week)
        <tr>
            @foreach ($week as $day)
            <td class="h-20 border p-1 align-top relative {{ $day['inMonth'] && $day['date']->isFuture() ? 'bg-gray-100 dark:bg-gray-800 opacity-60' : '' }} {{ $day['inMonth'] && !$day['date']->isFuture() ? 'cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700' : '' }}"
                @if ($day['inMonth'] && !$day['date']->isFuture()) onclick="redirectToDate('{{ $day['date']->toDateString() }}')" @endif>
                @if ($day['inMonth'])
                {{-- Gambar thumbnail --}}
                @if ($day['thumbnail'])
                <img src="{{ asset('storage/' . $day['thumbnail']) }}" alt="thumbnail"
                    class="absolute inset-0 object-cover w-full h-full opacity-60">
                @endif

                <div class="relative z-10 text-left text-xs text-white h-full flex flex-col justify-between">
                    {{-- Tanggal kecil di pojok kiri atas --}}
                    <div class="px-1 pt-0.5 {{ $day['date']->isFuture() ? 'text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-white' }} font-bold">
                        {{ $day['date']->day }}
                    </div>

                    {{-- Jika tidak ada gambar, tampilkan potongan isi --}}
                    @if (!$day['thumbnail'] && isset($day['content']) && $day['content'])
                    <div class="px-1 pb-0.5 truncate text-gray-700 dark:text-gray-300 text-xs italic">
                        {{ Str::limit(strip_tags($day['content']), 5) }}
                    </div>
                    @endif
                </div>
                @endif
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>