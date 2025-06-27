@props(['messages' => []])

@if ($messages)
<ul {{ $attributes->merge(['class' => '
        text-sm text-red-600 dark:text-red-400 space-y-1 
        w-full flex items-end justify-end'
        ]) }}>
    @foreach ((array) $messages as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
@endif