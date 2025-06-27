<x-guest-layout>
    <h1 class="text-3xl font-bold text-left mb-4 text-white">
        forgot your password?
    </h1>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-md space-y-6>
        @csrf

        <!-- Email Address -->
        <div class="w-full">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 flex items-end justify-end" />
        </div>

        <div class="flex items-end justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>