<x-app-layout>
    <x-header title="Settings" />

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            {{-- flex untuk responsif dan space antar card --}}
            <div class="flex flex-col lg:flex-row lg:items-start space-y-6 lg:space-y-0 lg:space-x-6">

                {{-- Update Profile --}}
                <div class="flex-1 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg
                            transition-all duration-500 ease-in-out">
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Update Password --}}
                <div class="flex-1 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg
                            transition-all duration-500 ease-in-out">
                    @include('profile.partials.update-password-form')
                </div>

                {{-- Delete Account --}}
                <div class="flex-1 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg
                            transition-all duration-500 ease-in-out">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
        </div>
    </div>
</x-app-layout>