@php

@endphp

<x-content-card>
    <h2 class="text-xl font-semibold mb-4">Submitted Proofs</h2>

    @if ($submittedTasks->isEmpty())
        <p class="text-xs text-center text-gray-500 dark:text-gray-400 italic">No submitted proofs yet.</p>
    @else
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
            @foreach ($submittedTasks as $task)
                @php
                    $modalId = 'remove-proof-modal-' . $task->id;
                @endphp

                <div class="relative group cursor-pointer">
                    <img src="{{ asset('storage/' . $task->proof_image) }}"
                        alt="Proof"
                        class="rounded-lg object-cover w-full h-24 border shadow-sm">

                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition rounded-lg">
                        <span class="text-white text-xs font-semibold">{{ $task->user->name }}</span>
                    </div>

                    @if ($challenge->creator_id === auth()->id())
                        <div class="absolute top-1 right-1">
                            <button type="button"
                                x-on:click="$dispatch('open-modal', '{{ $modalId }}')"
                                class="text-red-600 text-xs rounded-full px-1 py-0.5 transition hover:bg-red-100 dark:hover:bg-red-900">
                                ✕
                            </button>
                        </div>

                        <x-modal name="{{ $modalId }}" focusable>
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                    Remove {{ $task->user->name }}?
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    This action cannot be undone.
                                </p>

                                <form method="POST"
                                    action="{{ route('challenge.removeParticipant', [$challenge->id, $task->user_id]) }}"
                                    class="mt-4 flex justify-end gap-2">
                                    @csrf
                                    @method('DELETE')

                                    <x-secondary-button x-on:click="$dispatch('close')" type="button">
                                        Cancel
                                    </x-secondary-button>
                                    <x-danger-button type="submit">Remove</x-danger-button>
                                </form>
                            </div>
                        </x-modal>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-content-card>
