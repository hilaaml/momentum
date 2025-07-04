<x-modal name="edit-journal" :show="true">

    <form method="POST" action="{{ route('journal.update', $selectedJournal) }}"
        enctype="multipart/form-data"
        class="max-h-[80vh] overflow-y-auto overflow-x-hidden p-6 space-y-4">
        @csrf @method('PUT')

        <h2 class="font-bold text-gray-800 dark:text-gray-100">
            Edit - {{ $selectedDayLabel }}
        </h2>


        <textarea name="content"
            class="w-full border dark:bg-gray-700 dark:text-white p-2 rounded text-sm"
            rows="5">{{ old('content', $selectedJournal->content) }}</textarea>

        @if ($selectedJournal->image_path)
        <div>
            <img src="{{ asset('storage/' . $selectedJournal->image_path) }}"
                class="max-h-64 object-cover rounded shadow mx-auto mb-2">
        </div>
        @endif

        <div>
            <input type="file" name="image" class="dark:text-white text-sm">
        </div>

        <div class="flex justify-end pt-4 border-t dark:border-gray-700 gap-2">
            <x-primary-button type="submit">Update</x-primary-button>

            <x-secondary-button type="button"
                onclick="window.location.href='{{ route('journal.index', ['month' => $month, 'year' => $year, 'selected' => $selectedJournal->date->toDateString()]) }}'">
                Cancel
            </x-secondary-button>
        </div>

    </form>
</x-modal>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'edit-journal'
        }));
    });
</script>