@props(['seconds' => 0, 'active' => false])

<span class="w-24 font-mono text-xs text-gray-500 js-timer"
      data-seconds="{{ $seconds }}"
      data-active="{{ $active ? 'true' : 'false' }}"
      data-timer>
    {{ \Carbon\CarbonInterval::seconds($seconds)->cascade()->format('%H:%I:%S') }}
</span>
