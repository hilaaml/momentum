<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

            {{-- Edit Profile --}}
            <x-content-card>
                @include('profile.partials.update-profile-information-form')
            </x-content-card>

            {{-- Update Password --}}
            <x-content-card>
                @include('profile.partials.update-password-form')
            </x-content-card>

            {{-- Delete Account --}}
            <x-content-card>
                @include('profile.partials.delete-user-form')
            </x-content-card>

            {{-- Logout --}}
            <x-content-card>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-primary-button>
                        {{ __('Log Out') }}
                    </x-primary-button>
                </form>
            </x-content-card>

        </div>
    </div>
</x-app-layout>
