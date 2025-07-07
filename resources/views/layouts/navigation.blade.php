<aside
    x-data="sidebar()"
    x-init="init()"
    x-cloak
    class="h-full bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700
           p-4 flex flex-col justify-between text-sm text-gray-700 dark:text-gray-300 transition-all duration-500 overflow-y-auto">

    <div class="flex flex-col items-end gap-6 transition-all duration-300">

        <x-nav-btn
            @click="toggle()"
            aria-label="Toggle sidebar"
            class="text-gray-600 hover:text-indigo-600">

            <template x-if="expanded">
                <div class="w-5 h-5">
                    <div class="w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </div>
                </div>
            </template>

            <template x-if="!expanded">
                <div class="w-5 h-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </div>
            </template>
        </x-nav-btn>

        <nav class="flex flex-col gap-6">
            <x-nav-link href="{{ route('dashboard') }}" class="hover:text-indigo-600">
                <x-icon.logo class="w-5 h-5" />
                <span x-show="expanded" x-transition.opacity>Dashboard</span>
            </x-nav-link>

            <x-nav-link href="{{ route('reports') }}" class="hover:text-indigo-600">
                <svg {{ $attributes }} fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M4 19h16M8 13v6M12 10v9M16 6v13"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <span x-show="expanded" x-transition.opacity>Reports</span>
            </x-nav-link>

            <x-nav-link href="{{ route('journal.index') }}" class="hover:text-indigo-600">
                <svg {{ $attributes }} fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M4 4h16v16H4z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 4v16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span x-show="expanded" x-transition.opacity>Journal</span>
            </x-nav-link>
        </nav>
    </div>

    <div>
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-6"
            x-show="expanded" x-transition.opacity>
            {{ Auth::user()->name }}
            <a href="{{ route('profile.edit') }}" class="underline text-xs">(edit)</a>
            <div class="text-xs">{{ Auth::user()->email }}
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <x-nav-btn type="submit" class="hover:text-red-600 text-red-500 w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                </svg>
                <span x-show="expanded" x-transition.opacity>Logout</span>
            </x-nav-btn>
        </form>
    </div>
</aside>