@props([
'href' => null,
'type' => 'submit',
])

@if ($href)
<a href="{{ $href }}" {{ $attributes->merge([
    'class' => 'inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs lowercase tracking-widest rounded-md transition-all'
]) }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge([
    'class' => 'inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs lowercase tracking-widest rounded-md transition-all'
]) }}>
    {{ $slot }}
</button>
@endif