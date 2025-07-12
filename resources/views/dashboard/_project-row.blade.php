@props(['project'])

<!-- Baris utama tampilan project -->
<div class="flex items-center justify-between gap-4 mt-2">

    <!-- Bagian kiri: toggle dan nama project -->
    <div class="flex gap-5 items-center">
        <!-- Tombol untuk start/stop project -->
        @include('dashboard._project-toggle', ['project' => $project])

        <!-- Nama project -->
        <h3 class="text-base font-semibold truncate text-gray-600 dark:text-gray-300">
            {{ $project->name }}
        </h3>
    </div>

    <!-- Bagian kanan: timer dan menu dropdown -->
    <div class="flex items-center justify-end">
        <!-- Tampilan waktu total project + status aktif -->
        @include('dashboard._project-timer', [
            'seconds' => $project->total_seconds,
            'active' => $project->is_active
        ])

        <!-- Menu dropdown untuk project (edit/delete) -->
        @include('dashboard._project-menu', ['project' => $project])
    </div>
</div>
