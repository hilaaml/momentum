<x-content-card>
    <h2 class="text-sm text-gray-600 dark:text-gray-300">Owned Characters</h2>

    @if ($ownedCharacters->count())
        <div class="max-h-[200px] overflow-y-auto overflow-x-hidden">
            <div class="grid grid-cols-[repeat(auto-fit,minmax(100px,1fr))] gap-4 place-items-center">
                @foreach ($ownedCharacters as $character)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $character->image_path) }}"
                            alt="{{ $character->name }}"
                            class="w-20 h-20 object-cover mx-auto rounded">
                        <p class="text-sm mt-2 text-gray-700 dark:text-gray-300">{{ $character->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500">You don't own any characters yet.</p>
    @endif
</x-content-card>
