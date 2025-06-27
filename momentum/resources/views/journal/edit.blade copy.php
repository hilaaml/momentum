<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Jurnal
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <form method="POST" action="{{ route('journal.update', $journal->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal</label>
                <input type="date" name="date" id="date" value="{{ $journal->date->toDateString() }}" required class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Catatan</label>
                <textarea name="content" id="content" rows="5" required class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ $journal->content }}</textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ganti Gambar (opsional)</label>
                <input type="file" name="image" id="image" accept=".jpg,image/jpeg" class="mt-1">
                @if ($journal->image_path)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $journal->image_path) }}" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
            </div>

            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                Update
            </button>
        </form>
    </div>
</x-app-layout>
