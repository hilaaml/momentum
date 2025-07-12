@props(['project'])

<!-- Form untuk memulai atau menghentikan project -->
<form method="POST" action="{{ $project->isActive ? route('projects.stop', $project) : route('projects.start', $project) }}">
    @csrf

    <!-- Tombol toggle start/stop project -->
    <button type="submit"
        class="p-2 rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition">
        
        <!-- Ikon yang ditampilkan tergantung status aktif project -->
        @if ($project->isActive)
            <!-- Jika aktif, tampilkan ikon stop berwarna merah -->
            <x-icon.stop class="text-red-500" />
        @else
            <!-- Jika tidak aktif, tampilkan ikon play berwarna hijau -->
            <x-icon.play class="text-green-500" />
        @endif
    </button>
</form>
