<x-guest-layout>
    <div class="text-3xl font-bold text-center mb-6 text-white">
        create account
    </div>

    <form method="POST" action="{{ route('register') }}" class="w-full max-w-md space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input id="name" name="name" type="text"
                          class="block mt-1 w-full"
                          :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email" name="email" type="email"
                          class="block mt-1 w-full"
                          :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input id="password" name="password" type="password"
                          class="block mt-1 w-full"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                          class="block mt-1 w-full"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Already registered -->
        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('login') }}"
               class="underline text-sm text-white hover:text-gray-200">
                Already registered?
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
