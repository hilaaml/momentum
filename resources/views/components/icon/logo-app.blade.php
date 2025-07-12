<svg xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 200 200"
    fill="currentColor"
    {{ $attributes->merge(['class' => 'w-5 h-5']) }}>

    <circle cx="100" cy="100" r="100" fill="#000000" />

    <g stroke="#ffffff" stroke-width="8" stroke-linecap="round" transform="translate(100,100)">
        @for ($i = 0; $i
        < 12; $i++)
            <line x1="0" y1="-85" x2="0" y2="-95" transform="rotate({{ $i * 30 }})" />
        @endfor
    </g>

    <polyline points="70,100 90,120 130,80" fill="none" stroke="#ffffff" stroke-width="10"
        stroke-linecap="round" stroke-linejoin="round" />
</svg>