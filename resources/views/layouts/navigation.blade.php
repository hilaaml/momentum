<!-- Top Navigation -->
<aside
    x-cloak
    class="hidden md:flex bg-white dark:bg-gray-900 border-r border-border dark:border-border-dark 
           text-sm text-gray-700 dark:text-gray-300 transition-all duration-500 overflow-y-auto
           flex-col justify-between p-4 fixed inset-y-0 left-0 z-50"
    :class="expanded ? 'w-fit' : 'w-fit'">

    <div class="flex flex-col items-end gap-6">
        <x-nav-btn @click="toggle()" aria-label="Toggle sidebar" class="text-gray-600 hover:text-indigo-600">
            <div class="w-5 h-5">
                <template x-if="expanded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 19.5L3 12l7.5-7.5M3 12h18" />
                    </svg>
                </template>
                <template x-if="!expanded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3" />
                    </svg>
                </template>
            </div>
        </x-nav-btn>

        <nav class="flex flex-col gap-6 w-full max-w-full text-left">
            <x-nav-link :href="route('dashboard')" class="hover:text-indigo-600 flex items-center gap-x-2">
                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                    <x-icon.home class="w-5 h-5" />
                </div>
                <span x-show="expanded" x-transition.opacity class="whitespace-nowrap">Dashboard</span>
            </x-nav-link>

            <x-nav-link :href="route('reports')" class="hover:text-indigo-600 flex items-center gap-x-2">
                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                    <x-icon.chart class="w-5 h-5" />
                </div>
                <span x-show="expanded" x-transition.opacity class="whitespace-nowrap">Reports</span>
            </x-nav-link>

            <x-nav-link :href="route('journal.index')" class="hover:text-indigo-600 flex items-center gap-x-2">
                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                    <x-icon.journal class="w-5 h-5" />
                </div>
                <span x-show="expanded" x-transition.opacity class="whitespace-nowrap">Journal</span>
            </x-nav-link>

            <x-nav-link :href="route('rewards.index')" class="hover:text-indigo-600 flex items-center gap-x-2">
                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                    <x-icon.rewards class="w-5 h-5" />
                </div>
                <span x-show="expanded" x-transition.opacity class="whitespace-nowrap">Rewards</span>
            </x-nav-link>
        </nav>
    </div>

    <nav class="flex flex-col w-full max-w-full text-left">
        <div class="w-full border-t border-border dark:border-border-dark pt-4 mt-6 text-xs">
            <div x-show="expanded" x-transition.opacity class="mb-4">
                <div>{{ Auth::user()->name }}</div>
                <div>{{ Auth::user()->email }}</div>
            </div>
        </div>
        <x-nav-link :href="route('settings')" class="hover:text-indigo-600 flex items-center gap-x-2">
            <div class="w-5 h-5 flex items-center justify-center shrink-0">
                <x-icon.settings class="w-5 h-5" />
            </div>
            <span x-show="expanded" x-transition.opacity class="whitespace-nowrap">Settings</span>
        </x-nav-link>
    </nav>
</aside>

<!-- Bottom Navigation -->
@php
$navItems = [
['route' => 'reports', 'icon' => 'chart', 'label' => 'Reports'],
['route' => 'journal.index', 'icon' => 'journal', 'label' => 'Journal'],
['route' => 'dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
['route' => 'rewards.index', 'icon' => 'rewards', 'label' => 'Rewards'],
['route' => 'settings', 'icon' => 'settings', 'label' => 'Settings'],
];
@endphp

<nav class="md:hidden fixed bottom-0 w-full z-50 h-[64px]
    bg-white dark:bg-gray-900 border-t border-border dark:border-border-dark
    px-2 flex justify-between items-center text-xs">

    @foreach ($navItems as $item)
    <a href="{{ route($item['route']) }}" class="w-1/5 flex justify-center">
        <div class="flex flex-col items-center gap-0.5 px-3 py-1 rounded-lg transition-colors duration-200
                {{ request()->routeIs($item['route']) ? 'bg-primary/10 text-primary' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300' }}">

            <div class="w-5 h-5 flex items-center justify-center">
                @switch($item['icon'])
                @case('home') <x-icon.home class="w-5 h-5" /> @break
                @case('chart') <x-icon.chart class="w-5 h-5" /> @break
                @case('journal') <x-icon.journal class="w-5 h-5" /> @break
                @case('rewards') <x-icon.rewards class="w-5 h-5" /> @break
                @case('settings') <x-icon.settings class="w-5 h-5" /> @break
                @endswitch
            </div>

            <span class="text-[11px] leading-tight">{{ $item['label'] }}</span>
        </div>
    </a>
    @endforeach

</nav>