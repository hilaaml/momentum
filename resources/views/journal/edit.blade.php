<x-app-layout>

    @section('content')
    <div class="container">
        <h2 class="text-xl font-bold mb-4">Edit Journal - {{ $journal->date }}</h2>
        <form action="{{ route('journal.update', $journal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Isi Catatan:</label>
                <textarea name="content" rows="6" class="w-full border p-2">{{ old('content', $journal->content) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block">Gambar Lama:</label>
                @if($journal->image_path)
                <img src="{{ asset('storage/' . $journal->image_path) }}" class="w-32 mb-2">
                @else
                <p><i>Tidak ada gambar</i></p>
                @endif

                <label>Upload Gambar Baru (opsional):</label>
                <input type="file" name="image" accept=".jpg,.jpeg">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>

        </form>
    </div>
</x-app-layout>