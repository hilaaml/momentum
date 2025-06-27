<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lihat Jurnal
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-4">
            <p class="text-gray-600 dark:text-gray-300"><strong>Tanggal:</strong> {{ $journal->date->format('d F Y') }}</p>
            <div>
                <p class="text-gray-700 dark:text-gray-200 whitespace-pre-line">{{ $journal->content }}</p>
            </div>

            @if ($journal->image_path)
            <div>
                <img src="{{ asset('storage/' . $journal->image_path) }}" class="w-full rounded shadow mt-4">
            </div>
            @endif

            <div class="flex gap-2 mt-4">
                <a href="{{ route('journal.edit', $journal) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                <form method="POST" action="{{ route('journal.destroy', $journal) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
