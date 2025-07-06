<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs lowercase tracking-widest rounded-md transition-all'
    ]) }}>
    {{ $slot }}
</button>
