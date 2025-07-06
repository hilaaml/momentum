<x-guest-layout>
    <h1 class="text-4xl font-bold mb-2 text-indigo-700 dark:text-indigo-400">momentum</h1>
    <p class="text-gray-700 dark:text-gray-300 mb-8">
        Organize your tasks, track every minute, generate insightful reports, and see your productivity soar — all in one beautiful dashboard.
    </p>

    <form method="POST" action="{{ route('register') }}" class="w-full space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-text-input id="name" name="name" type="text"
                          class="block w-full"
                          placeholder="Name"
                          :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-text-input id="email" name="email" type="email"
                          class="block w-full"
                          placeholder="Email"
                          :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-text-input id="password" name="password" type="password"
                          class="block w-full"
                          placeholder="Password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                          class="block w-full"
                          placeholder="Confirm Password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-all">
            Sign up
        </button>
    </form>

    <div class="my-6 relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-100 dark:border-gray-800"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-gray-100 dark:bg-gray-800 px-4 text-sm text-gray-600 dark:text-gray-400">OR</span>
        </div>
    </div>

    <div class="flex flex-row gap-x-6 justify-center items-center w-full">
        <a href="{{ route('socialite.redirect', 'google') }}" class="flex items-center justify-center bg-white dark:bg-gray-800 border border-indigo-600 dark:border-indigo-400 text-indigo-600 dark:text-indigo-400 p-3 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700 transition-all">
            <svg width="28" height="28" viewBox="0 0 20 20"><g><path fill="#4285F4" d="M19.6 10.23c0-.68-.06-1.36-.18-2H10v3.79h5.5c-.24 1.28-.97 2.37-2.06 3.09v2.56h3.34c1.96-1.81 3.09-4.48 3.09-7.44z"/><path fill="#34A853" d="M10 20c2.7 0 4.97-.89 6.63-2.44l-3.34-2.56c-.92.62-2.09.99-3.29.99-2.53 0-4.68-1.71-5.44-4.01H1.09v2.52C2.82 17.98 6.18 20 10 20z"/><path fill="#FBBC05" d="M4.56 12.98A5.97 5.97 0 0 1 4.09 10c0-.99.18-1.95.47-2.98V4.5H1.09A9.96 9.96 0 0 0 0 10c0 1.64.39 3.19 1.09 4.5l3.47-2.52z"/><path fill="#EA4335" d="M10 4c1.48 0 2.8.51 3.85 1.51l2.89-2.89C14.97 1.18 12.7 0 10 0 6.18 0 2.82 2.02 1.09 5.5l3.47 2.52C5.32 5.71 7.47 4 10 4z"/></g></svg>
        </a>
        <a href="{{ route('socialite.redirect', 'github') }}" class="flex items-center justify-center bg-white dark:bg-gray-800 border border-indigo-600 dark:border-indigo-400 text-indigo-600 dark:text-indigo-400 p-3 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700 transition-all">
            <svg class="w-7 h-7" fill="#ffffff" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.373 0 12c0 5.303 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.744.083-.729.083-.729 1.205.085 1.84 1.237 1.84 1.237 1.07 1.834 2.809 1.304 3.495.997.108-.775.418-1.305.762-1.605-2.665-.305-5.466-1.334-5.466-5.93 0-1.31.467-2.38 1.235-3.22-.123-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.289-1.552 3.295-1.23 3.295-1.23.653 1.653.241 2.873.118 3.176.77.84 1.233 1.91 1.233 3.22 0 4.61-2.803 5.624-5.475 5.921.43.372.823 1.102.823 2.222 0 1.606-.014 2.898-.014 3.293 0 .322.216.694.825.576C20.565 21.796 24 17.298 24 12c0-6.627-5.373-12-12-12z"/></svg>
        </a>
    </div>

    <!-- Already registered -->
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}"
           class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600">
            Already have an account? Log in
        </a>
    </div>
</x-guest-layout>
