@props(['seconds' => 0])
<p id="main-timer"
   data-timer
   data-seconds="{{ $seconds }}"
   class="text-3xl font-mono text-indigo-600 mt-2">
    {{ \Carbon\CarbonInterval::seconds($seconds)->cascade()->format('%H:%I:%S') }}
</p>
