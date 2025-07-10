<x-content-card centerXY>
    <form method="GET" action="{{ route('reports') }}" class="flex flex-wrap items-end gap-4">
        @foreach (['from' => 'From', 'to' => 'To'] as $field => $label)
        <div class="flex flex-col">
            <label class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}:</label>
            @php
            $defaultDate = $field === 'from' ? $from : $to;
            @endphp
            <input type="date" name="{{ $field }}"
                value="{{ request($field, $defaultDate->toDateString()) }}"
                class="rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-1 py-1 text-xs">
        </div>
        @endforeach
        <x-primary-button class="p-2">Show</x-primary-button>
    </form>
</x-content-card>
