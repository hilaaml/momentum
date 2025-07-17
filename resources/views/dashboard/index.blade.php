<x-app-layout>
    <div class="pb-6">
        @include('dashboard._unlocked-character')
        @include('dashboard._streak-timer-section')
    </div>
    <div class="space-y-6">
        @include('dashboard._challenge-list')
        @include('dashboard._project-task-section')
    </div>
</x-app-layout>