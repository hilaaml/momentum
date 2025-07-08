@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
'class' => '
border-border
dark:border-border-dark
dark:bg-background.dark
dark:text-text-light
focus:border-primary
dark:focus:border-primary.dark
focus:ring-primary
dark:focus:ring-primary.dark
rounded-md shadow-sm
'
]) !!}
>