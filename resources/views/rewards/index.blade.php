<x-app-layout>
    <div class="max-w-3xl mx-auto mt-8 space-y-6">

        @include('rewards._header')
        @include('rewards._add-modal')

        @if ($rewards->count())
            @include('rewards._list')
        @else
            @include('rewards._empty')
        @endif

    </div>
</x-app-layout>
