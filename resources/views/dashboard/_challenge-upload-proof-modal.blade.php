<x-modal name="upload-proof-{{ $challenge->id }}" focusable>
    <div class="p-4">
        <h2 class="mb-2 pb-2 border-b text-sm font-semibold text-gray-600 dark:text-gray-300">Upload Challenge Proof - {{ $challenge->title }}</h2>
        <form action="{{ route('challenges.uploadProof', $challenge->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="block mb-1 text-sm font-medium text-gray-700">Proof File</label>
            <input type="file" name="proof" required class="text-sm mb-4 w-full">
            <div class="flex justify-end gap-2">
                <x-secondary-button type="button"
                    x-on:click="$dispatch('close')"
                    class="px-4 py-1 text-sm rounded border border-gray-400 text-gray-600 hover:bg-gray-100">
                    Cancel
                </x-secondary-button>
                <x-primary-button type="submit"
                    class="px-4 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                    Upload
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>