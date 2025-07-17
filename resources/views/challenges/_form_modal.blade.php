<x-modal name="create-challenge-modal" focusable>
    <form action="{{ route('challenges.store') }}" method="POST" class="p-6 space-y-4">
        @csrf
        <h2 class="mb-2 pb-2 border-b text-sm font-semibold text-gray-600 dark:text-gray-300">Create a New Challenge</h2>

        <div>
            <label class="block text-sm font-medium">Title</label>
            <input name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border rounded" />
            @error('title') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium">Type</label>
            <select name="type" id="modal-challenge-type" required class="w-full px-3 py-2 border rounded">
                <option value="">-- Select Type --</option>
                <option value="time" {{ old('type') == 'time' ? 'selected' : '' }}>Time Oriented</option>
                <option value="task" {{ old('type') == 'task' ? 'selected' : '' }}>Task Oriented</option>
            </select>
            @error('type') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div id="modal-time-target-wrapper" style="display: none;">
            <label class="block text-sm font-medium">Target Time Per Day (in seconds)</label>
            <input name="target_seconds" value="{{ old('target_seconds') }}" class="w-full px-3 py-2 border rounded" />
            @error('target_seconds') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Duration (days)</label>
            <input type="number" name="target_days" value="{{ old('target_days') }}" required class="w-full px-3 py-2 border rounded" />
            @error('target_days') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div>
            <p class="text-red text-xs">Are you sure? This challenge can't be edited later.</p>
        </div>

        <div class="flex justify-end gap-2">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
            <x-primary-button type="submit">Create</x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('modal-challenge-type').addEventListener('change', function() {
            const wrapper = document.getElementById('modal-time-target-wrapper');
            wrapper.style.display = this.value === 'time' ? 'block' : 'none';
        });
        document.getElementById('modal-challenge-type').dispatchEvent(new Event('change'));
    </script>
</x-modal>