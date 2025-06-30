@props([
'class' => '',
'centerXY' => false, // aktifkan untuk center X dan Y
])

@php
$base = "flex-1 p-4 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-2xl transition-all duration-300";
$centerClass = $centerXY ? 'flex justify-center items-center h-full' : '';
@endphp

<div {{ $attributes->merge(['class' => "$base $centerClass $class"]) }}>
    {{ $slot }}
</div>