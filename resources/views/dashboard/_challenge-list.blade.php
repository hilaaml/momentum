@if ($challengesWithProgress->isNotEmpty())
<div>
    <x-content-card>
        @foreach ($challengesWithProgress as $challenge)
            @include('dashboard._challenge-row', ['challenge' => $challenge])
        @endforeach
    </x-content-card>
</div>
@endif
