<x-app-layout>
    <div class="space-y-6">
        @include('challenges._detail', ['challenge' => $challenge])

        @if ($challenge->type === 'task')
            @include('challenges._proof-grid', ['challenge' => $challenge])
        @endif
    </div>
</x-app-layout>
