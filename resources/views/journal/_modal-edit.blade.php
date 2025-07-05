<x-modal name="edit-journal" :show="true">

    <form method="POST" action="{{ route('journal.update', $selectedJournal) }}"
        enctype="multipart/form-data"
        class="max-h-[80vh] overflow-y-auto overflow-x-hidden p-6 space-y-4">
        @csrf @method('PUT')

        <h2 class="font-bold text-gray-800 dark:text-gray-100">
            Edit - {{ $selectedDayLabel }}
        </h2>

        <div>
            <textarea name="content"
                class="w-full border dark:bg-gray-700 dark:text-white p-2 rounded text-sm"
                rows="5" required>{{ old('content', $selectedJournal->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        @if ($selectedJournal->image_path)
        <div>
            <img src="{{ asset('storage/' . $selectedJournal->image_path) }}"
                class="max-h-64 object-cover rounded shadow mx-auto mb-2">
        </div>
        @endif

        <div>
            <input type="file" name="image" class="dark:text-white text-sm" accept="image/jpeg,image/jpg,image/png,image/webp">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Allowed formats: JPG, JPEG, PNG, WEBP (max 5MB)</p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
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