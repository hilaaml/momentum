<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

            <!-- Edit Profile -->
            <x-content-card>
                @include('profile.partials.update-profile-information-form')
            </x-content-card>

            <!-- Update Password -->
            <x-content-card>
                @include('profile.partials.update-password-form')
            </x-content-card>

            <!-- Delete Account -->
            <x-content-card>
                @include('profile.partials.delete-user-form')
            </x-content-card>

            <!-- Logout -->
            <x-content-card>
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Log Out') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Logging out will end your current session. Make sure to save your work before continuing.') }}
                        </p>
                    </header>

                    <x-danger-button
                        type="button" {{-- <== INI WAJIB supaya tidak submit form --}}
                        x-data
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')">
                        {{ __('Log Out') }}
                    </x-danger-button>

                    <x-modal name="confirm-logout" focusable>
                        <form method="POST" action="{{ route('logout') }}" class="p-6">
                            @csrf

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Are you sure you want to log out?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('You will be signed out of your account and redirected to the login page.') }}
                            </p>

                            <div class="mt-6 flex items-center justify-end">
                                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ms-3">
                                    {{ __('Log Out') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </section>
            </x-content-card>

        </div>
    </div>
</x-app-layout>