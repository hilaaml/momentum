<div class="flex justify-between items-center mb-4">
    {{-- Tombol Sebelumnya --}}
    @php
    $prevMonth = \Carbon\Carbon::create($year, $month, 1)->subMonth();
    $nextMonth = \Carbon\Carbon::create($year, $month, 1)->addMonth();
    @endphp

    <a href="{{ route('journal.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}"
        class="text-lg px-3 py-1 rounded border bg-gray-200 dark:bg-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600">
        &lt;
    </a>

    {{-- Form Filter --}}
    <form method="GET" class="flex gap-2 items-center">
        <select name="month" class="border rounded p-1 dark:bg-gray-800 dark:text-white">
            @foreach ($monthOptions as $key => $label)
            <option value="{{ $key }}" {{ $key == $month ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        <select name="year" class="border rounded p-1 pr-8 dark:bg-gray-800 dark:text-white">
            @for ($y = now()->year - 5; $y <= now()->year + 2; $y++)
                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
        </select>

        <x-primary-button class="px-2 py-1 bg-indigo-600 text-white rounded">Show</x-primary-button>
    </form>

    {{-- Tombol Berikutnya --}}
    <a href="{{ route('journal.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}"
        class="text-lg px-3 py-1 rounded border bg-gray-200 dark:bg-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600">
        &gt;
    </a>
</div>