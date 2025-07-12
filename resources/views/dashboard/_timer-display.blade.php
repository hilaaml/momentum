<!-- Komponen Blade dengan properti 'seconds' default ke 0 -->
@props(['seconds' => 0])

<p id="main-timer"
   data-timer
   data-seconds="{{ $seconds }}"
   class="text-3xl font-mono text-indigo-600 dark:text-indigo-400 mt-2">
    {{ $formattedTodayTime }}
</p>
