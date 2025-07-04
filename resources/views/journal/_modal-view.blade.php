<x-modal name="view-journal" show="true">
    <div class="max-h-[80vh] overflow-y-auto p-6 space-y-4">

        <div class="flex items-center justify-between">
            <h2 class="font-bold text-gray-800 dark:text-gray-100">
                {{ $selectedDayLabel }}
            </h2>

            <div class="flex items-center gap-2">
                <a href="?month={{ $month }}&year={{ $year }}&selected={{ $selectedJournal->date->toDateString() }}&edit=true"
                   title="Edit">
                    <x-secondary-button class="py-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 4h2a2 2 0 012 2v2m0 0L7 19H5v-2l12-12z"/>
                        </svg>
                    </x-secondary-button>
                </a>

                <form method="POST" action="{{ route('journal.destroy', $selectedJournal) }}">
                    @csrf @method('DELETE')
                    <x-danger-button class="py-1" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-3-3v3"/>
                        </svg>
                    </x-danger-button>
                </form>
            </div>
        </div>

        @if ($selectedJournal->image_path)
        <div>
            <img src="{{ asset('storage/' . $selectedJournal->image_path) }}"
                 class="max-h-64 object-cover rounded shadow mx-auto">
        </div>
        @endif

        <div class="text-sm text-gray-700 dark:text-gray-200 whitespace-pre-line break-all">
            {{ $selectedJournal->content }}
        </div>

    </div>
</x-modal>
