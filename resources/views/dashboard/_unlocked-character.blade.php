@if ($unlockedCharacters->count())
@php $character = $unlockedCharacters->last(); @endphp

<div class="flex justify-end mr-4">
    <img src="{{ asset('storage/' . $character->image_path) }}"
         alt="{{ $character->name }}"
         class="w-20 h-20 object-cover">
</div>
@endif
