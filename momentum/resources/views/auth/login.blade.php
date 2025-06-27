<x-guest-layout>
    <h1 class="text-3xl font-bold mb-6 text-white">welcome back!</h1>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- ①  Tambahkan w-full & (opsional) max-w-md supaya rapi --}}
    <form method="POST" action="{{ route('login') }}"
        class="w-full max-w-md space-y-6"> {{-- ✓  --}}

        @csrf

        {{-- Email --}}
        <div class="w-full">
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required autofocus autocomplete="username"
                class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <x-text-input id="password"
                name="password"
                type="password"
                required autocomplete="current-password"
                class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember --}}
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox"
                name="remember"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="ml-2 text-sm text-white">Remember me</span>
        </label>

        {{-- Submit / Forgot --}}
        <div class="flex items-center justify-between pt-4">
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                class="text-sm underline text-white hover:text-gray-200">
                Forgot your password?
            </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>