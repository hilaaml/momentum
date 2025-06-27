<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Jurnal
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <form method="POST" action="{{ route('journal.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal</label>
                <input type="date" name="date" id="date" value="{{ old('date', now()->toDateString()) }}" required class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Catatan</label>
                <textarea name="content" id="content" rows="5" required class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('content') }}</textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Gambar (.jpg, min. 1MB)</label>
                <input type="file" name="image" id="image" accept=".jpg,image/jpeg" class="mt-1">
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>
