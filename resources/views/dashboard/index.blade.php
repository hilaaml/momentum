<x-app-layout>

    <div class="py-3 mx-auto flex flex-col space-y-6 ">

        <div>
            <!-- Tampilkan karakter terakhir yang berhasil di-unlock -->
            @if ($unlockedCharacters->count())
            @php
            $character = $unlockedCharacters->last();
            @endphp

            <div class="flex justify-end  mr-4">
                <img src="{{ asset('storage/' . $character->image_path) }}"
                    alt="{{ $character->name }}"
                    class="w-20 h-20 object-cover">
            </div>
            @endif

            <!-- Timer dan streak -->
            <x-content-card>
                <div class="flex justify-between items-center">
                    <div>
                        <!-- Total waktu kerja hari ini -->
                        @include('dashboard._timer-display', ['seconds' => $totalTodayInSeconds])

                        <!-- Button timeline -->
                        <button
                            x-data
                            x-on:click="$dispatch('open-modal', 'timeline-modal')"
                            class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            timeline &rarr;
                        </button>

                        <x-modal name="timeline-modal" :show="false">
                            <div class="p-6 space-y-4">
                                <h2> Today Work Log </h2>
                                <x-timeline-table :logs="$todayLogs" />
                                <div class="flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">Close</x-secondary-button>
                                </div>
                            </div>
                        </x-modal>
                    </div>

                    <!-- Streak -->
                    <div class="text-center cursor-pointer"
                        x-data
                        @click="$dispatch('open-modal', 'streak-setting-modal')">
                        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Streak</h2>
                        <p class="text-2xl text-green-500 font-bold">{{ auth()->user()->getStreakDays() }}d</p>
                    </div>
                </div>
                <x-modal name="streak-setting-modal" focusable>
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ __('Set Minimum Productive Time per Day for Streak') }}
                        </h2>

                        <!-- Form untuk menyimpan konfigurasi streak -->
                        <form method="POST" action="{{ route('dashboard.streak-config') }}" class="mt-4 space-y-4">
                            @csrf
                            <label for="streak_minute_input" class="block text-sm text-gray-700 dark:text-gray-300">
                                Minimum time per day (in minutes):
                            </label>
                            <input type="number" name="streak_minute_input" min="1"
                                value="{{ old('streak_minute_input', floor(auth()->user()->streak_minimum_seconds / 60)) }}"
                                class="w-full rounded border border-gray-300 dark:bg-gray-800 dark:text-white px-2 py-1" required>

                            <x-primary-button class="w-full">{{ __('Save') }}</x-primary-button>
                        </form>
                    </div>
                </x-modal>
            </x-content-card>
        </div>

        <!-- Daftar project dan task -->
        <x-content-card>

            <!-- Project -->
            @forelse ($projects as $project)

            @include('dashboard._project-row', ['project' => $project])

            <!-- Task -->
            <ul class="mt-2 pl-9 space-y-2">
                @foreach ($project->tasks as $task)
                @include('dashboard._task-row', ['task' => $task])
                @endforeach
            </ul>

            @empty

            <p class="py-4 text-center text-gray-500 dark:text-gray-300">You haven't created any projects.</p>

            @endforelse

            <!-- Tombol tambah project baru -->
            <div class="flex justify-end">
                <x-secondary-button
                    x-data
                    x-on:click="$dispatch('open-modal', 'create-project')"
                    class="ml-auto mt-4 block">
                    + Project
                </x-secondary-button>
            </div>

            <x-modal name="create-project" focusable>
                <form method="POST" action="{{ route('projects.store') }}" class="pb-6 pt-3 px-6 space-y-3">
                    @csrf
                    <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Add new project </h2>
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