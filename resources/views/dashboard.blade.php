<x-app-layout>

    <x-header title="Dashboard" />

    <div class="py-3 px-12 mx-auto flex flex-col space-y-6 ">

        <x-content-card>
            <div class="flex justify-between items-center">
                <div>
                    <x-timer-display :seconds="$totalTodayInSeconds" />

                    <button
                        x-data
                        x-on:click="$dispatch('open-modal', 'timeline-modal')"
                        class="text-indigo-600 hover:underline text-sm">
                        timeline &rarr;
                    </button>
                    <x-modal name="timeline-modal" :show="false">
                        <div class="p-6 space-y-4">
                            <h2> \Timeline Hari Ini </h2>
                            <x-timeline-table :logs="$todayLogs" />
                            <div class="flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">Tutup</x-secondary-button>
                            </div>
                        </div>
                    </x-modal>
                </div>
                <x-streak :streak="$streak" />
            </div>
        </x-content-card>

        <x-content-card>

            @forelse ($projects as $project)
            <x-project-row :project="$project" />

            <ul class="mt-2 pl-9 space-y-2">
                @foreach ($project->tasks as $task)
                <x-task-row :task="$task" />
                @endforeach
            </ul>

            @empty
            <p class="py-4 text-center text-gray-500 dark:text-gray-300">Belum ada proyek.</p>
            @endforelse

            <div class="flex justify-end">
                <x-primary-button
                    x-data
                    x-on:click="$dispatch('open-modal', 'create-project')"
                    class="ml-auto mt-4 block">
                    + Project
                </x-primary-button>
            </div>
            <x-modal name="create-project" focusable>
                <form method="POST" action="{{ route('projects.store') }}" class="pb-6 pt-3 px-6 space-y-3">
                    @csrf
                    <h2>Add new project </h2>
                    <div>
                        <x-text-input id="name" name="name" required autofocus class="mt-1 block w-full" placeholder="project name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="ml-2">Save</x-primary-button>
                    </div>
                </form>
            </x-modal>
        </x-content-card>
        
    </div>
</x-app-layout>