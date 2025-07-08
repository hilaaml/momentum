@props([
'href' => null,
'type' => 'submit',
])

@if ($href)
<a href="{{ $href }}" {{ $attributes->merge([
    'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-indigo-600 dark:border-indigo-400 rounded-md text-xs lowercase text-indigo-600 dark:text-indigo-400 tracking-widest shadow-sm hover:bg-indigo-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge([
    'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-indigo-600 dark:border-indigo-400 rounded-md text-xs lowercase text-indigo-600 dark:text-indigo-400 tracking-widest shadow-sm hover:bg-indigo-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
@endif