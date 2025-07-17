<x-app-layout>
    <div class="space-y-6">
        <x-content-card>
            <a href="{{ route('challenges.show', $challenge->id) }}"
                class="text-xs text-gray-500 hover:underline">
                Participants \
            </a>
            <h1 class="text-2xl font-bold mb-2">{{ $challenge->title }}</h1>
            <p class="text-xs text-gray-500">
                Total Participants: {{ $challenge->participants->count() }} <br>
                Completed: {{
            $challenge->participants->filter(function($participant) use ($challenge) {return $participant->completed_days >= $challenge->target_days; })->count() }}
            </p>
        </x-content-card>

        <x-content-card>
            @if ($challenge->participants->isEmpty())
            <p class="text-sm text-center text-gray-500 italic">No participants yet.</p>
            @else
            @foreach ($challenge->participants as $participant)
            @php
            $latestCharacter = $participant->characters->first();
            @endphp
            <div class="border-b p-4 mb-2 bg-white flex items-center gap-4 justify-between">
                <div class="flex items-center gap-4">
                    @if ($latestCharacter)
                    <img src="{{ asset('storage/' . $latestCharacter->image_path) }}"
                        alt="{{ $latestCharacter->name }}"
                        class="w-10 h-10 object-cover">
                    @else
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">N/A</div>
                    @endif
                    <div>
                        <div class="font-semibold">{{ $participant->name }}</div>
                        <div class="text-sm text-gray-600">
                            Progress: {{ $participant->completed_days }} / {{ $challenge->target_days }} days
                        </div>
                    </div>
                </div>

                @if ($challenge->creator_id === auth()->id())
                <x-danger-button
                    x-data
                    @click="$dispatch('open-modal', { name: 'confirm-remove-{{ $participant->id }}' })"
                    class="text-xs px-2 py-1">
                    Remove
                </x-danger-button>

                <x-modal name="confirm-remove-{{ $participant->id }}" focusable>
                    <form method="POST"
                        action="{{ route('challenge.removeParticipant', [$challenge->id, $participant->id]) }}"
                        class="p-6">
                        @csrf
                        @method('DELETE')

                        <h2 class="text-lg font-medium text-gray-900">Are you sure?</h2>
                        <p class="mt-1 text-sm text-gray-600">This will remove the participant and their progress.</p>

                        <div class="mt-6 flex justify-end gap-2">
                            <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                            <x-danger-button type="submit">Remove</x-danger-button>
                        </div>
                    </form>
                </x-modal>
                @endif
            </div>
            @endforeach
            @endif
        </x-content-card>
    </div>
</x-app-layout>