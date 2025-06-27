@props(['class' => ''])

<div {{ $attributes->merge([
        'class' => "flex-1 justify-end p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg
                    transition-all duration-500 ease-in-out $class"
    ]) }}>
    {{ $slot }}
</div>