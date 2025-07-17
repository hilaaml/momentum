<div class="flex items-center justify-between gap-4 py-2">
    <div class="flex gap-5 items-center">
        <div class="w-8 h-8 flex items-center justify-center rounded transition
            @if($challenge->is_completed_today)
                bg-green-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600
            @else
                bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600
            @endif">

            @if ($challenge->type === 'time')
                @if ($challenge->is_completed_today)
                    <x-icon.check />
                @else
                    <span class="text-[0.6rem] text-gray-700">-{{ $challenge->remaining_minutes_today }}m</span>
                @endif

            @elseif ($challenge->type === 'task')
                @if ($challenge->is_completed_today)
                    <x-icon.check />
                @else
                    <button x-data x-on:click="$dispatch('open-modal', 'upload-proof-{{ $challenge->id }}')" title="Upload Proof" class="w-full h-full flex items-center justify-center">
                        <x-icon.upload />
                    </button>

                    @include('dashboard._challenge-upload-proof-modal', ['challenge' => $challenge])
                @endif
            @endif
        </div>

        <h3 class="text-base font-semibold truncate text-gray-600 dark:text-gray-300">
            {{ $challenge->title }}
        </h3>
    </div>

    <div class="flex items-center justify-end font-mono text-xs">
        ({{ $challenge->streak }}/{{ $challenge->target_days }}d)
    </div>
</div>
