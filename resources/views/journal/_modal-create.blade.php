<!-- Modal untuk membuat jurnal baru -->
<x-modal name="create-journal" :show="true">

    <!-- Form input untuk menyimpan jurnal baru -->
    <form method="POST"
          action="{{ route('journal.store') }}"
          enctype="multipart/form-data"
          class="p-6 space-y-4">
        @csrf

        <!-- Judul modal menampilkan tanggal yang dipilih -->
        <h2 class="font-bold text-gray-800 dark:text-gray-100">
            Add - {{ $selectedDayLabel }}
        </h2>

        <!-- Tanggal tersembunyi untuk jurnal -->
        <input type="hidden" name="date" value="{{ $selectedDay }}">

        <!-- Textarea untuk isi jurnal -->
        <div>
            <textarea name="content"
                      class="w-full border dark:bg-gray-700 dark:text-white p-2 rounded"
                      rows="4"
                      required>{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input upload gambar -->
        <div>
            <input type="file"
                   name="image"
                   class="dark:text-white"
                   accept="image/jpeg,image/jpg,image/png,image/webp">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Allowed formats: JPG, JPEG, PNG, WEBP (max 5MB)
            </p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol aksi -->
        <div class="flex justify-end pt-4 border-t dark:border-gray-700 gap-2">
            <!-- Tombol simpan -->
            <x-primary-button
                type="submit"
                class="bg-green-600 text-white px-3 py-1 rounded">
                Save
            </x-primary-button>

            <!-- Tombol batal -->
            <x-secondary-button
                type="button"
                class="text-gray-600 dark:text-gray-300"
                x-on:click="$dispatch('close-modal', 'create-journal')">
                Cancel
            </x-secondary-button>
        </div>
    </form>
</x-modal>
