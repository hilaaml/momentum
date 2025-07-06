<x-modal name="create-journal" :show="true">

    <form method="POST" action="{{ route('journal.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
        @csrf
        <h2 class="font-bold text-gray-800 dark:text-gray-100">Add - {{ $selectedDayLabel }}</h2>

        <input type="hidden" name="date" value="{{ $selectedDay }}">
        
        <div>
            <textarea name="content" class="w-full border dark:bg-gray-700 dark:text-white p-2 rounded" rows="4" required>{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <input type="file" name="image" class="dark:text-white" accept="image/jpeg,image/jpg,image/png,image/webp">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Allowed formats: JPG, JPEG, PNG, WEBP (max 5MB)</p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end pt-4 border-t dark:border-gray-700 gap-2">
            <x-primary-button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Save</x-primary-button>
            <x-secondary-button type="button" class="text-gray-600 dark:text-gray-300" x-on:click="$dispatch('close-modal', 'create-journal')">Cancel</x-secondary-button>
        </div>
    </form>
</x-modal>