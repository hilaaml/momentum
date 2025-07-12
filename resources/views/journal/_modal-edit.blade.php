<!-- Modal untuk mengedit jurnal yang dipilih -->
<x-modal name="edit-journal" :show="true">

    <!-- Form untuk update jurnal -->
    <form method="POST"
        action="{{ route('journal.update', $selectedJournal) }}"
        enctype="multipart/form-data"
        class="max-h-[80vh] overflow-y-auto overflow-x-hidden p-6 space-y-4">
        @csrf
        @method('PUT')

        <!-- Judul modal dengan tanggal yang diformat -->
        <h2 class="font-bold text-gray-800 dark:text-gray-100">
            Edit - {{ $selectedDayLabel }}
        </h2>

        <!-- Textarea untuk konten jurnal -->
        <div>
            <textarea name="content"
                class="w-full border dark:bg-gray-700 dark:text-white p-2 rounded text-sm"
                rows="5"
                required>{{ old('content', $selectedJournal->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tampilkan gambar lama jika ada -->
        @if ($selectedJournal->image_path)
        <div>
            <img src="{{ asset('storage/' . $selectedJournal->image_path) }}"
                class="max-h-64 object-cover rounded shadow mx-auto mb-2">
        </div>
        @endif

        <!-- Input untuk upload gambar baru -->
        <div>
            <input type="file" name="image"
                class="dark:text-white text-sm"
                accept="image/jpeg,image/jpg,image/png,image/webp">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Allowed formats: JPG, JPEG, PNG, WEBP (max 5MB)
            </p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol aksi: Update dan Cancel -->
        <div class="flex justify-end pt-4 border-t dark:border-gray-700 gap-2">
            <!-- Submit form untuk update -->
            <x-primary-button type="submit">Update</x-primary-button>

            <!-- Cancel dan kembali ke tampilan view -->
            <x-secondary-button type="button"
                onclick="window.location.href='{{ route('journal.index', ['month' => $month, 'year' => $year, 'selected' => $selectedJournal->date->toDateString()]) }}'">
                Cancel
            </x-secondary-button>
        </div>

    </form>
</x-modal>
