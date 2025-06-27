@php
use Carbon\Carbon;
@endphp

<x-app-layout>
    {{-- PILIH BULAN & TAHUN --}}
    <div class="flex justify-between items-center mb-4">
        <form method="GET" class="flex gap-2">
            <select name="month" class="border rounded p-1 dark:bg-gray-800 dark:text-white">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                    {{ Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                    @endfor
            </select>
            <select name="year" class="border rounded p-1 dark:bg-gray-800 dark:text-white">
                @for ($y = now()->year - 5; $y <= now()->year + 2; $y++)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
            </select>
            <button class="px-2 py-1 bg-indigo-600 text-white rounded">Tampilkan</button>
        </form>

        <a href="{{ route('journal.create') }}" class="bg-green-600 text-white px-4 py-1 rounded">+ Tambah Journal</a>
    </div>

    {{-- NAMA BULAN --}}
    <h2 class="text-xl font-bold mb-4 text-center">
        {{ strtoupper(Carbon::create()->month($month)->translatedFormat('F Y')) }}
    </h2>

    {{-- GENERATE KALENDER --}}
    @php
    $start = Carbon::create($year, $month)->startOfMonth();
    $end = $start->copy()->endOfMonth();
    $firstDayOfWeek = $start->dayOfWeek;
    $daysInMonth = $start->daysInMonth;
    $dateCounter = $start->copy()->subDays($firstDayOfWeek);
    @endphp

    <table class="w-full table-fixed text-center border-collapse mb-4">
        <thead>
            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                @foreach (['Su','Mo','Tu','We','Th','Fr','Sa'] as $day)
                <th class="p-2">{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for ($week = 0; $week < 6; $week++)
                <tr>
                @for ($day = 0; $day < 7; $day++)
                    @php
                    $currentDate=$dateCounter->copy();
                    $key = $currentDate->toDateString();
                    $journal = $journals->first(fn($j) => $j->date->toDateString() === $key);

                    $thumbnail = $journal && $journal->image_path ? $journal->image_path : null;
                    @endphp

                    <td class="h-20 border p-1 cursor-pointer relative hover:bg-gray-100 dark:hover:bg-gray-700"
                        @if ($currentDate->month == $month)
                        onclick="window.location='?month={{ $month }}&year={{ $year }}&selected={{ $key }}'"
                        @endif>
                        @if ($currentDate->month == $month)
                        @if ($thumbnail)
                        <img src="{{ asset('storage/' . $thumbnail) }}"
                            alt="thumbnail"
                            class="absolute inset-0 object-cover w-full h-full opacity-60 rounded">
                        @endif
                        <span class="relative z-10 font-bold text-sm text-white bg-black/50 px-1 rounded">
                            {{ $currentDate->day }}
                        </span>
                        @endif
                        @php $dateCounter->addDay(); @endphp
                    </td>
                    @endfor
                    </tr>
                    @endfor
        </tbody>
    </table>

    {{-- DETAIL JURNAL TANGGAL TERPILIH --}}
    @if ($selectedDay)
    <div class="mt-6 p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h3 class="text-lg font-bold mb-4">
            Jurnal Tanggal {{ Carbon::parse($selectedDay)->translatedFormat('d F Y') }}
        </h3>

        @if ($selectedJournal)
        <div class="mb-4 border-b pb-2">
            <p class="text-sm dark:text-gray-200">
                {{ \Illuminate\Support\Str::limit($selectedJournal->content, 100) }}
            </p>
            @if ($selectedJournal->image_path)
            <img src="{{ asset('storage/' . $selectedJournal->image_path) }}" class="mt-2 w-32 h-32 object-cover rounded">
            @endif

            <div class="flex gap-2 mt-2">
                <a href="{{ route('journal.show', $selectedJournal) }}" class="text-blue-600 hover:underline text-sm">Buka</a>
                <a href="{{ route('journal.edit', $selectedJournal) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                <form method="POST" action="{{ route('journal.destroy', $selectedJournal) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                </form>
            </div>
        </div>
        @else
        <p class="text-sm mb-2">Belum ada jurnal untuk tanggal ini.</p>
        <a href="{{ route('journal.create', ['date' => $selectedDay]) }}"
            class="inline-block bg-green-600 text-white px-3 py-1 rounded">+ Tambah Jurnal</a>
        @endif
    </div>
    @endif
</x-app-layout>